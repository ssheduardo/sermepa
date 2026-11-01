<?php

/**
 * Minimal HTTPS mock server used by the TLS integration harness.
 *
 * Accepts a single TLS connection, reads the request, and returns a fixed
 * JSON response. The server exits after serving one request so each test case
 * starts with a fresh process and certificate context.
 *
 * Usage:
 *   php MockServer.php <port> <server-cert-pem> <server-key-pem>
 */

if ($argc !== 4) {
    fwrite(STDERR, "Usage: {$argv[0]} <port> <server-cert> <server-key>\n");
    exit(1);
}

$port = $argv[1];
$cert = $argv[2];
$key = $argv[3];

$context = stream_context_create([
    'ssl' => [
        'local_cert' => $cert,
        'local_pk' => $key,
        'verify_peer' => false,
        'verify_peer_name' => false,
        'disable_compression' => true,
        'allow_self_signed' => true,
    ],
]);

$socket = @stream_socket_server(
    "ssl://0.0.0.0:{$port}",
    $errno,
    $errstr,
    STREAM_SERVER_BIND | STREAM_SERVER_LISTEN,
    $context
);

if (!$socket) {
    fwrite(STDERR, "Server error: {$errstr} ({$errno})\n");
    exit(1);
}

$connection = stream_socket_accept($socket, 5);

if ($connection) {
    // Consume the request so the client can receive the response cleanly.
    fread($connection, 8192);

    $body = '{"result":"ok"}';
    $response = "HTTP/1.1 200 OK\r\n"
        . "Content-Type: application/json\r\n"
        . "Content-Length: " . strlen($body) . "\r\n"
        . "Connection: close\r\n"
        . "\r\n"
        . $body;

    fwrite($connection, $response);
    fclose($connection);
}

fclose($socket);
