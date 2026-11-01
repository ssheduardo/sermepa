<?php

/**
 * End-to-end TLS harness for Sermepa\Tpv custom CA support.
 *
 * This script is intentionally standalone: it generates an ephemeral CA and
 * server certificates, starts a local HTTPS mock Redsys endpoint, and exercises
 * the three certificate verification outcomes that matter for the public API:
 *
 *   1. Trusted custom CA -> request succeeds.
 *   2. Unknown CA -> request fails because the server cert is not trusted.
 *   3. Hostname mismatch -> request fails because the cert SAN does not match.
 *
 * All keys and certificates are written to a temporary directory and removed
 * when the script finishes, regardless of success or failure.
 */

require __DIR__ . '/../../../vendor/autoload.php';

use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

function fail(string $message): void
{
    fwrite(STDERR, "FAIL: {$message}\n");
    exit(1);
}

function pass(string $message): void
{
    echo "PASS: {$message}\n";
}

function findFreePort(): int
{
    $socket = @stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
    if (!$socket) {
        throw new Exception("Unable to find a free port: {$errstr} ({$errno})");
    }

    $name = stream_socket_get_name($socket, false);
    fclose($socket);

    if ($name === false || strpos($name, ':') === false) {
        throw new Exception('Unable to determine free port number.');
    }

    return (int) substr($name, strrpos($name, ':') + 1);
}

function createTempDir(): string
{
    $tmp = sys_get_temp_dir() . '/sermepa-tls-' . uniqid();
    if (!mkdir($tmp, 0700, true) && !is_dir($tmp)) {
        throw new Exception("Unable to create temp directory {$tmp}");
    }

    return $tmp;
}

function runOpenssl(string $args): void
{
    $command = 'openssl ' . $args . ' 2>&1';
    exec($command, $output, $exitCode);
    if ($exitCode !== 0) {
        throw new Exception("OpenSSL command failed:\n" . implode("\n", $output));
    }
}

function generateCertificates(string $tmpDir): array
{
    $caKey = $tmpDir . '/ca.key';
    $caCert = $tmpDir . '/ca.crt';
    $unknownCaKey = $tmpDir . '/unknown-ca.key';
    $unknownCaCert = $tmpDir . '/unknown-ca.crt';
    $serverKey = $tmpDir . '/server.key';
    $serverCsr = $tmpDir . '/server.csr';
    $serverCert = $tmpDir . '/server.crt';
    $wrongKey = $tmpDir . '/wrong.key';
    $wrongCsr = $tmpDir . '/wrong.csr';
    $wrongCert = $tmpDir . '/wrong.crt';

    // Trusted test CA.
    runOpenssl("genrsa -out {$caKey} 2048");
    runOpenssl("req -x509 -new -nodes -key {$caKey} -sha256 -days 1 -subj '/CN=Sermepa Test CA' -out {$caCert}");

    // Untrusted CA used to prove that verification is strict.
    runOpenssl("genrsa -out {$unknownCaKey} 2048");
    runOpenssl("req -x509 -new -nodes -key {$unknownCaKey} -sha256 -days 1 -subj '/CN=Sermepa Unknown CA' -out {$unknownCaCert}");

    // Server certificate with SAN for the mock hostname.
    $serverExt = $tmpDir . '/server.ext';
    file_put_contents($serverExt, "subjectAltName=DNS:sermepa-tls.test\n");
    runOpenssl("genrsa -out {$serverKey} 2048");
    runOpenssl("req -new -key {$serverKey} -subj '/CN=sermepa-tls.test' -out {$serverCsr}");
    runOpenssl("x509 -req -in {$serverCsr} -CA {$caCert} -CAkey {$caKey} -CAcreateserial -out {$serverCert} -days 1 -sha256 -extfile {$serverExt}");

    // Server certificate for a different hostname to exercise host verification.
    $wrongExt = $tmpDir . '/wrong.ext';
    file_put_contents($wrongExt, "subjectAltName=DNS:wrong.sermepa-tls.test\n");
    runOpenssl("genrsa -out {$wrongKey} 2048");
    runOpenssl("req -new -key {$wrongKey} -subj '/CN=wrong.sermepa-tls.test' -out {$wrongCsr}");
    runOpenssl("x509 -req -in {$wrongCsr} -CA {$caCert} -CAkey {$caKey} -CAcreateserial -out {$wrongCert} -days 1 -sha256 -extfile {$wrongExt}");

    return [
        'caCert' => $caCert,
        'unknownCaCert' => $unknownCaCert,
        'serverKey' => $serverKey,
        'serverCert' => $serverCert,
        'wrongKey' => $wrongKey,
        'wrongCert' => $wrongCert,
    ];
}

/**
 * @return array{0: resource, 1: array<int, resource>}
 */
function startMockServer(string $cert, string $key, int $port): array
{
    $command = [
        'php',
        __DIR__ . '/MockServer.php',
        (string) $port,
        $cert,
        $key,
    ];

    $descriptors = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];

    $process = proc_open($command, $descriptors, $pipes);
    if (!is_resource($process)) {
        throw new Exception('Failed to start mock server process.');
    }

    // Close stdin immediately; we only read output on failure.
    fclose($pipes[0]);

    // Wait briefly for the TLS socket to be ready.
    usleep(500000);

    $status = proc_get_status($process);
    if (!$status['running']) {
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        throw new Exception("Mock server exited prematurely.\n{$stderr}");
    }

    return [$process, $pipes];
}

/**
 * @param resource $process
 * @param array<int, resource> $pipes
 */
function stopMockServer($process, array $pipes): void
{
    foreach ($pipes as $pipe) {
        if (is_resource($pipe)) {
            fclose($pipe);
        }
    }

    $status = proc_get_status($process);
    if ($status['running']) {
        proc_terminate($process);
    }
    proc_close($process);
}

function buildTpvForTlsTest(string $url): Tpv
{
    $tpv = new Tpv();
    $tpv->setEnvironment('restTest')
        ->setAmount(100)
        ->setOrder('1234TLSHARN')
        ->setMerchantcode('999008881')
        ->setCurrency('978')
        ->setTransactiontype('0')
        ->setTerminal('1')
        ->setMerchantSignature('test_signature');

    // setEnvironment only accepts Redsys URLs, so inject the mock endpoint
    // through reflection to keep the public API unchanged.
    $reflection = new ReflectionClass($tpv);
    $property = $reflection->getProperty('_setEnvironment');
    $property->setAccessible(true);
    $property->setValue($tpv, $url);

    return $tpv;
}

function assertCertificateFailure(TpvException $exception, string $context): void
{
    $message = strtolower($exception->getMessage());
    if (strpos($message, 'ssl') === false && strpos($message, 'certificate') === false) {
        fail("{$context} failed for a non-certificate reason: " . $exception->getMessage());
    }
}

function scenarioTrustedCa(int $port, string $caCert): void
{
    $url = "https://sermepa-tls.test:{$port}/sis/rest/trataPeticionREST";
    $tpv = buildTpvForTlsTest($url);
    $tpv->setCaInfo($caCert);

    $response = $tpv->send();

    if ($response !== '{"result":"ok"}') {
        fail("Trusted CA scenario returned unexpected response: {$response}");
    }

    pass('Trusted custom CA connects successfully and returns the expected body.');
}

function scenarioUnknownCa(int $port, string $unknownCaCert): void
{
    $url = "https://sermepa-tls.test:{$port}/sis/rest/trataPeticionREST";
    $tpv = buildTpvForTlsTest($url);
    $tpv->setCaInfo($unknownCaCert);

    try {
        $tpv->send();
        fail('Unknown CA scenario should have rejected the server certificate.');
    } catch (TpvException $e) {
        assertCertificateFailure($e, 'Unknown CA scenario');
        pass('Unknown CA is correctly rejected.');
    }
}

function scenarioHostnameMismatch(int $port, string $caCert): void
{
    // The server presents a certificate for wrong.sermepa-tls.test while the
    // client requests sermepa-tls.test, so host verification must fail.
    $url = "https://sermepa-tls.test:{$port}/sis/rest/trataPeticionREST";
    $tpv = buildTpvForTlsTest($url);
    $tpv->setCaInfo($caCert);

    try {
        $tpv->send();
        fail('Hostname mismatch scenario should have rejected the certificate.');
    } catch (TpvException $e) {
        assertCertificateFailure($e, 'Hostname mismatch scenario');
        pass('Hostname mismatch is correctly rejected.');
    }
}

function runScenario(callable $scenario, int $port, string $cert, string $key, ...$args): void
{
    list($process, $pipes) = startMockServer($cert, $key, $port);

    try {
        $scenario($port, ...$args);
    } finally {
        stopMockServer($process, $pipes);
    }
}

function removeTempDirectory(string $tmpDir): void
{
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($tmpDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $file) {
        $path = $file->getPathname();
        if ($file->isDir()) {
            rmdir($path);
        } else {
            unlink($path);
        }
    }

    rmdir($tmpDir);
}

// -----------------------------------------------------------------------------

$tmpDir = createTempDir();

try {
    echo "Generating ephemeral certificates in {$tmpDir}...\n";
    $certs = generateCertificates($tmpDir);

    $port = findFreePort();
    echo "Using mock HTTPS endpoint on port {$port}.\n";

    runScenario('scenarioTrustedCa', $port, $certs['serverCert'], $certs['serverKey'], $certs['caCert']);
    runScenario('scenarioUnknownCa', $port, $certs['serverCert'], $certs['serverKey'], $certs['unknownCaCert']);
    runScenario('scenarioHostnameMismatch', $port, $certs['wrongCert'], $certs['wrongKey'], $certs['caCert']);
} finally {
    echo "Cleaning up temporary certificates...\n";
    removeTempDirectory($tmpDir);
}

echo "\nAll TLS harness scenarios passed.\n";
