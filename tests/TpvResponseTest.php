<?php

declare(strict_types=1);

namespace Sermepa\Tpv;

use PHPUnit\Framework\TestCase;
use Sermepa\Tpv\Tpv;

class TpvResponseTest extends TestCase
{

    public function test_response_error_code()
    {
        $response = [
            'errorCode' => '123'
        ];

        $key = 'YOUR_KEY';

        $redsys = $this->createMock(Tpv::class);
        $redsys->method('getMerchantParameters')->willReturn(['Ds_Response' => '00']);
        $redsys->method('check')->willReturn(true);

        try {

            if (array_key_exists('errorCode', $response)) {
                throw new \Exception("Error en la respuesta: " . $response['errorCode']);
            } else {
                $parameters = $redsys->getMerchantParameters($response['Ds_MerchantParameters']);
                $DsResponse = $parameters["Ds_Response"];
                $DsResponse += 0;
                if ($redsys->check($key, $response) && $DsResponse <= 99) {
                    print_r($parameters);
                } else {
                    throw new \Exception("Error en la verificación de la respuesta.");
                }
            }
        } catch (\Exception $e) {
            $this->assertEquals("Error en la respuesta: 123", $e->getMessage());
        }
    }

    public function test_successful_response()
    {
        $response = [
            'Ds_MerchantParameters' => 'encodedParams',
            'Ds_Signature' => 'signature'
        ];

        $key = 'YOUR_KEY';

        $redsys = $this->createMock(Tpv::class);
        $redsys->method('getMerchantParameters')->willReturn([
            'Ds_Response' => '00',
            'Ds_MerchantParameters' => 'param'
        ]);

        $redsys->method('check')->willReturn(true);

        try {
            if (array_key_exists('errorCode', $response)) {
                throw new \Exception("Error en la respuesta: " . $response['errorCode']);
            } else {
                $parameters = $redsys->getMerchantParameters($response['Ds_MerchantParameters']);
                $DsResponse = $parameters["Ds_Response"];
                $DsResponse += 0;
                if ($redsys->check($key, $response) && $DsResponse <= 99) {
                    $this->assertTrue(true); // Success
                } else {
                    throw new \Exception("Error en la verificación de la respuesta.");
                }
            }
        } catch (\Exception $e) {
            $this->fail("No se esperaba una excepción: " . $e->getMessage());
        }
    }
}
