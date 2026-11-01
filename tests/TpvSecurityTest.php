<?php

declare(strict_types=1);

namespace Sermepa\Tpv;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TpvSecurityTest extends PHPUnitTestCase
{
    /**
     * Build a Tpv instance configured for REST tests with a valid signature.
     */
    private function buildTestableTpv(): TestableTpv    {
        $tpv = new TestableTpv();
        $tpv->setEnvironment('restTest')
            ->setAmount(100)
            ->setOrder('1234ABCD')
            ->setMerchantcode('999008881')
            ->setCurrency('978')
            ->setTransactiontype('0')
            ->setTerminal('1')
            ->setMerchantSignature('test_signature');

        return $tpv;
    }

    /**
     * Capture E_USER_WARNING messages emitted while running the callback.
     *
     * @param callable $callback
     *
     * @return array<int, string>
     */
    private function collectWarnings(callable $callback): array
    {
        $messages = [];

        set_error_handler(function ($errno, $errstr) use (&$messages) {
            $messages[] = $errstr;

            return true;
        }, E_USER_WARNING);

        try {
            $callback();
        } finally {
            restore_error_handler();
        }

        return $messages;
    }

    /** @test */
    public function send_returns_response_body_on_http_200()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $result = $tpv->send();

        $this->assertSame('{"result":"ok"}', $result);
    }

    /** @test */
    public function send_throws_tpv_exception_on_non_200_http_code()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage("Request failure [HttpCode: '500']");

        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = [false, 500, ''];

        $tpv->send();
    }

    /** @test */
    public function send_includes_curl_error_in_exception_message()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage("Request failure [HttpCode: '0'] [Error: 'Connection refused']");

        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = [false, 0, 'Connection refused'];

        $tpv->send();
    }

    /** @test */
    public function send_throws_tpv_exception_when_json_encode_fails()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Failed to encode request data to JSON');

        $tpv = $this->buildTestableTpv();
        $tpv->forceEncodeFailure = true;

        $tpv->send();
    }

    /** @test */
    public function send_throws_tpv_exception_when_curl_init_fails()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Failed to initialize cURL request');

        $tpv = $this->buildTestableTpv();
        $tpv->forceInitFailure = true;

        $tpv->send();
    }

    /** @test */
    public function send_enforces_tls_certificate_and_host_verification()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertArrayHasKey(CURLOPT_SSL_VERIFYHOST, $tpv->capturedOptions);
        $this->assertSame(2, $tpv->capturedOptions[CURLOPT_SSL_VERIFYHOST]);
        $this->assertArrayHasKey(CURLOPT_SSL_VERIFYPEER, $tpv->capturedOptions);
        $this->assertTrue($tpv->capturedOptions[CURLOPT_SSL_VERIFYPEER]);
    }

    /** @test */
    public function allowInsecureTls_disables_curl_verification_only_when_explicitly_requested()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $this->collectWarnings(function () use ($tpv) {
            $tpv->allowInsecureTls();
        });
        $tpv->send();

        $this->assertSame(0, $tpv->capturedOptions[CURLOPT_SSL_VERIFYHOST]);
        $this->assertFalse($tpv->capturedOptions[CURLOPT_SSL_VERIFYPEER]);
    }

    /** @test */
    public function allowInsecureTls_emits_a_warning_naming_the_risk_and_the_fix()
    {
        $tpv = new Tpv();

        $warnings = $this->collectWarnings(function () use ($tpv) {
            $tpv->allowInsecureTls();
        });

        $this->assertCount(1, $warnings);
        $this->assertStringContainsString('verification disabled', $warnings[0]);
        $this->assertStringContainsString('setCaInfo', $warnings[0]);
    }

    /** @test */
    public function allowInsecureTls_can_be_reverted_to_strict_verification()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $warnings = $this->collectWarnings(function () use ($tpv) {
            $tpv->allowInsecureTls()->allowInsecureTls(false);
        });
        $tpv->send();

        $this->assertCount(1, $warnings, 'Only enabling the insecure mode warns.');
        $this->assertSame(2, $tpv->capturedOptions[CURLOPT_SSL_VERIFYHOST]);
        $this->assertTrue($tpv->capturedOptions[CURLOPT_SSL_VERIFYPEER]);
    }

    /** @test */
    public function allowInsecureTls_is_disabled_by_default()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $warnings = $this->collectWarnings(function () use ($tpv) {
            $tpv->send();
        });

        $this->assertCount(0, $warnings);
        $this->assertSame(2, $tpv->capturedOptions[CURLOPT_SSL_VERIFYHOST]);
        $this->assertTrue($tpv->capturedOptions[CURLOPT_SSL_VERIFYPEER]);
    }

    /** @test */
    public function send_preserves_timeouts_and_rest_configuration()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertArrayHasKey(CURLOPT_CONNECTTIMEOUT, $tpv->capturedOptions);
        $this->assertSame(Tpv::TIMEOUT, $tpv->capturedOptions[CURLOPT_CONNECTTIMEOUT]);
        $this->assertArrayHasKey(CURLOPT_TIMEOUT, $tpv->capturedOptions);
        $this->assertSame(Tpv::READ_TIMEOUT, $tpv->capturedOptions[CURLOPT_TIMEOUT]);
        $this->assertArrayHasKey(CURLOPT_RETURNTRANSFER, $tpv->capturedOptions);
        $this->assertTrue($tpv->capturedOptions[CURLOPT_RETURNTRANSFER]);
        $this->assertArrayHasKey(CURLOPT_POST, $tpv->capturedOptions);
        $this->assertTrue($tpv->capturedOptions[CURLOPT_POST]);
    }

    /** @test */
    public function send_does_not_set_ca_options_by_default()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertArrayNotHasKey(CURLOPT_CAINFO, $tpv->capturedOptions);
        $this->assertArrayNotHasKey(CURLOPT_CAPATH, $tpv->capturedOptions);
    }

    /** @test */
    public function send_applies_ca_info_when_configured()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->setCaInfo('/tmp/custom-ca.pem');
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertArrayHasKey(CURLOPT_CAINFO, $tpv->capturedOptions);
        $this->assertSame('/tmp/custom-ca.pem', $tpv->capturedOptions[CURLOPT_CAINFO]);
    }

    /** @test */
    public function send_applies_ca_path_when_configured()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->setCaPath('/tmp/certs');
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertArrayHasKey(CURLOPT_CAPATH, $tpv->capturedOptions);
        $this->assertSame('/tmp/certs', $tpv->capturedOptions[CURLOPT_CAPATH]);
    }

    /** @test */
    public function send_preserves_verification_when_ca_options_are_set()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->setCaInfo('/tmp/custom-ca.pem')->setCaPath('/tmp/certs');
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertSame(2, $tpv->capturedOptions[CURLOPT_SSL_VERIFYHOST]);
        $this->assertTrue($tpv->capturedOptions[CURLOPT_SSL_VERIFYPEER]);
    }

    /** @test */
    public function send_allows_unsetting_ca_info_with_null()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->setCaInfo('/tmp/custom-ca.pem')->setCaInfo(null);
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $tpv->send();

        $this->assertArrayNotHasKey(CURLOPT_CAINFO, $tpv->capturedOptions);
    }

    /** @test */
    public function set_ca_methods_return_this_for_chaining()
    {
        $tpv = new Tpv();

        $this->assertSame($tpv, $tpv->setCaInfo('/tmp/ca.pem'));
        $this->assertSame($tpv, $tpv->setCaPath('/tmp/certs'));
    }

    /** @test */
    public function send_in_site_stores_and_sends_generated_signature()
    {
        $tpv = $this->buildTestableTpv();
        $tpv->mockCurlResponse = ['{"result":"ok"}', 200, ''];

        $key = base64_encode(str_repeat('k', 24));
        $tpv->sendInSite('idOper123', $key);

        $signature = $tpv->getMerchantSignature();
        $this->assertNotEmpty($signature);
        $this->assertNotSame('test_signature', $signature);

        $this->assertArrayHasKey(CURLOPT_POSTFIELDS, $tpv->capturedOptions);
        $payload = json_decode($tpv->capturedOptions[CURLOPT_POSTFIELDS], true);
        $this->assertIsArray($payload);
        $this->assertArrayHasKey('Ds_Signature', $payload);
        $this->assertSame($signature, $payload['Ds_Signature']);
        $this->assertArrayHasKey('Ds_MerchantParameters', $payload);
        $this->assertArrayHasKey('Ds_SignatureVersion', $payload);
    }

    /** @test */
    public function check_throws_when_post_data_is_null()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Add data return of bank');

        $tpv = new Tpv();
        $tpv->check('test_key', null);
    }

    /** @test */
    public function check_throws_when_required_fields_are_missing()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Missing required notification fields');

        $tpv = new Tpv();
        $tpv->check('test_key', ['Ds_MerchantParameters' => 'abc']);
    }

    /** @test */
    public function check_throws_when_parameters_are_empty()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Invalid notification parameters');

        $tpv = new Tpv();
        $tpv->check('test_key', ['Ds_MerchantParameters' => '', 'Ds_Signature' => 'sig']);
    }

    /** @test */
    public function check_throws_when_parameters_are_malformed_base64()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Invalid notification parameters: malformed Base64');

        $tpv = new Tpv();
        $tpv->check('test_key', ['Ds_MerchantParameters' => '!!!not-base64!!!', 'Ds_Signature' => 'sig']);
    }

    /** @test */
    public function check_throws_when_parameters_contain_malformed_json()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Invalid notification parameters: malformed JSON');

        $parameters = strtr(base64_encode('not valid json'), '+/', '-_');

        $tpv = new Tpv();
        $tpv->check('test_key', ['Ds_MerchantParameters' => $parameters, 'Ds_Signature' => 'sig']);
    }

    /** @test */
    public function check_throws_when_order_is_missing()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Invalid notification parameters: missing order');

        $parameters = strtr(base64_encode('{"amount":"100"}'), '+/', '-_');

        $tpv = new Tpv();
        $tpv->check('test_key', ['Ds_MerchantParameters' => $parameters, 'Ds_Signature' => 'sig']);
    }

    /** @test */
    public function check_returns_false_for_invalid_signature()
    {
        $key = base64_encode(str_repeat('k', 24));
        $parameters = strtr(base64_encode('{"Ds_Order":"1234"}'), '+/', '-_');

        $tpv = new Tpv();
        $result = $tpv->check($key, [
            'Ds_MerchantParameters' => $parameters,
            'Ds_Signature' => 'invalid_signature',
        ]);

        $this->assertFalse($result);
    }

    /** @test */
    public function check_returns_true_for_valid_url_safe_base64_signature()
    {
        $key = base64_encode(str_repeat('k', 24));
        $parameters = strtr(base64_encode('{"Ds_Order":"1234"}'), '+/', '-_');

        $tpv = new Tpv();
        $signature = $tpv->generateMerchantSignatureNotification($key, $parameters);

        $result = $tpv->check($key, [
            'Ds_MerchantParameters' => $parameters,
            'Ds_Signature' => $signature,
        ]);

        $this->assertTrue($result);
    }

    /** @test */
    public function getMerchantParameters_throws_on_malformed_base64()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Invalid parameters: malformed Base64');

        $tpv = new Tpv();
        $tpv->getMerchantParameters('!!!not-base64!!!');
    }

    /** @test */
    public function getMerchantParameters_throws_on_malformed_json()
    {
        $this->expectException(TpvException::class);
        $this->expectExceptionMessage('Invalid parameters: malformed JSON');

        $tpv = new Tpv();
        $tpv->getMerchantParameters(base64_encode('not valid json'));
    }

    /** @test */
    public function getMerchantParameters_decodes_valid_url_safe_base64_json()
    {
        $expected = ['Ds_Order' => '1234', 'Ds_Response' => '00'];
        $parameters = strtr(base64_encode(json_encode($expected)), '+/', '-_');

        $tpv = new Tpv();
        $result = $tpv->getMerchantParameters($parameters);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function createForm_escapes_dynamic_html_attributes()
    {
        $tpv = new Tpv();
        $tpv->setEnvironment('test')
            ->setNameForm('form" onload="x')
            ->setIdForm("id'x")
            ->setAttributesSubmit('btn"', "id'y", 'Pay <now>', 'font-family: "Arial";', 'btn\'class');

        $form = $tpv->createForm();

        $this->assertStringContainsString('name="form&quot; onload=&quot;x"', $form);
        $this->assertStringContainsString('id="id&#039;x"', $form);
        $this->assertStringContainsString('name="btn&quot;"', $form);
        $this->assertStringContainsString('id="id&#039;y"', $form);
        $this->assertStringContainsString('value="Pay &lt;now&gt;"', $form);
        $this->assertStringContainsString('style="font-family: &quot;Arial&quot;;"', $form);
        $this->assertStringContainsString('class="btn&#039;class"', $form);
        $this->assertStringNotContainsString('form" onload="x"', $form);
        $this->assertStringNotContainsString('Pay <now>', $form);
    }

    /** @test */
    public function createInSiteForm_escapes_dynamic_html_and_javascript_values()
    {
        $tpv = new Tpv();
        $tpv->setEnvironment('insiteSandbox')
            ->setOrder('1234')
            ->setMerchantcode('999008881')
            ->setTerminal('1');

        $form = $tpv->createInSiteForm(
            "card'form",
            "background: url('x');",
            '',
            '',
            '',
            "Pay's",
            'ES'
        );

        $this->assertStringContainsString('id="card&#039;form"', $form);
        $this->assertStringContainsString("'card\\'form'", $form);
        $this->assertStringContainsString("'background: url(\\'x\\');'", $form);
        $this->assertStringContainsString("'Pay\\'s'", $form);
        $this->assertStringNotContainsString("<div id=\"card'form\"", $form);
    }

    /** @test */
    public function createInSiteForm_neutralises_closing_script_tags_in_javascript_strings()
    {
        $tpv = new Tpv();
        $tpv->setEnvironment('insiteSandbox')
            ->setOrder('1234')
            ->setMerchantcode('999008881')
            ->setTerminal('1');

        $form = $tpv->createInSiteForm(
            'card-form',
            '',
            '',
            '',
            '',
            '</script><script>alert(1)</script>'
        );

        $this->assertStringContainsString("<\\/script>", $form);
        $this->assertStringNotContainsString('</script><script>alert(1)</script>', $form);
    }

    /** @test */
    public function createInSiteFormJSON_uses_safe_json_encoding_and_escapes_html_attributes()
    {
        $tpv = new Tpv();
        $tpv->setEnvironment('insiteSandbox');

        $form = $tpv->createInSiteFormJSON([
            'id' => "card'form",
            'fuc' => '999008881',
            'terminal' => '1',
            'order' => '1234',
            'buttonValue' => 'Pay</script><script>alert(1)</script>',
        ]);

        $this->assertStringContainsString('id="card&#039;form"', $form);
        $this->assertStringContainsString('"fuc":"999008881"', $form);
        $this->assertStringContainsString('Pay\\u003C/script\\u003E', $form);
        $this->assertStringNotContainsString('</script><script>alert(1)</script>', $form);
    }

    /** @test */
    public function executeRedirection_escapes_the_form_name_inside_the_javascript_submit_call()
    {
        $tpv = new Tpv();
        $tpv->setEnvironment('test')
            ->setNameForm('form"></script><script>alert(1)</script>');

        $html = $tpv->executeRedirection(true);

        $this->assertStringContainsString('document.forms["form\\"><\\/script><script>alert(1)<\\/script>"]', $html);
        $this->assertStringNotContainsString('document.forms["form"></script>', $html);
        $this->assertStringNotContainsString('"></script><script>alert(1)</script>', $html);
    }

    /** @test */
    public function executeRedirection_keeps_the_default_form_selector_unchanged()
    {
        $tpv = new Tpv();
        $tpv->setEnvironment('test');

        $html = $tpv->executeRedirection(true);

        $this->assertStringContainsString('document.forms["redsys_form"].submit();', $html);
    }
}

/**
 * Testable subclass that exposes seam methods for the protected cURL helpers
 * so the transport can be exercised without a live Redsys endpoint.
 */
class TestableTpv extends Tpv
{
    /** @var bool */
    public $forceEncodeFailure = false;

    /** @var bool */
    public $forceInitFailure = false;

    /** @var array|null */
    public $mockCurlResponse = null;

    /** @var array<int, mixed> */
    public $capturedOptions = [];

    protected function encodeRequestData(array $data)
    {
        if ($this->forceEncodeFailure) {
            return false;
        }

        return parent::encodeRequestData($data);
    }

    protected function initCurlHandle()
    {
        if ($this->forceInitFailure) {
            return false;
        }

        return parent::initCurlHandle();
    }

    protected function executeCurlRequest($rest)
    {
        if ($this->mockCurlResponse !== null) {
            return $this->mockCurlResponse;
        }

        return parent::executeCurlRequest($rest);
    }

    protected function setCurlOption($rest, $option, $value)
    {
        $this->capturedOptions[$option] = $value;

        return parent::setCurlOption($rest, $option, $value);
    }
}
