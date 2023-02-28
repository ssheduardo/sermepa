<?php

namespace Sermepa\Tpv;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TpvTest extends PHPUnitTestCase
{

    /** @test */
    public function identifier_by_default_required()
    {
        $redsys = new Tpv();
        $redsys->setIdentifier();
        $this->assertContains('REQUIRED', $redsys->getParameters());
    }

    public function booleanProvider()
    {
        return [
            [true],
            [false]
        ];
    }

    /**
     * @test
     * @dataProvider booleanProvider
     */
    public function merchant_direct_payment_return_false_or_true($boolean)
    {
        $redsys = new Tpv();
        $redsys->setMerchantDirectPayment($boolean);
        $ds = $redsys->getParameters();
        $this->assertIsBool( $ds['DS_MERCHANT_DIRECTPAYMENT']);
    }

    public function amountProvider()
    {
        return [
            [0, '00,00'],
            [3330, '33,3'],
            [790, 7.9],
            [91200, 912],
            [100, '01'],
            [6990, 69.90],
            [3060056, 30600.56]
        ];
    }

    /**
     * @test
     * @dataProvider amountProvider
     */
    public function amount_is_valid($correctAmount, $amount)
    {
        $redsys = new Tpv();
        $redsys->setAmount($amount);
        $ds = $redsys->getParameters();
        $this->assertEquals($correctAmount, $ds['DS_MERCHANT_AMOUNT']);

    }


    /**
     * @test
     * @dataProvider amountProvider
     */
    public function sum_total_is_valid($correctAmount, $amount)
    {
        $redsys = new Tpv();
        $redsys->setSumTotal($amount);
        $ds = $redsys->getParameters();
        $this->assertEquals($correctAmount, $ds['DS_MERCHANT_SUMTOTAL']);

    }

    /**
     * @test
     */
    public function throw_sum_total_is_invalid_number()
    {
        $this->expectExceptionMessage("Sum total must be greater than or equal to 0.");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setSumTotal(-1);
    }


    public function dateFrecuencyProvider()
    {
        return [
            [3],
            [75],
            [490],
            [9120]
        ];
    }

    /**
     * @test
     * @dataProvider dateFrecuencyProvider
     */
    public function date_frecuency_is_valid($dateFrecuency)
    {
        $redsys = new Tpv();
        $redsys->setDateFrecuency($dateFrecuency);
        $parameters = $redsys->getParameters();

        $this->assertArrayHasKey('DS_MERCHANT_DATEFRECUENCY', $parameters);
    }

    public function invalidDateFrecuencyProvider()
    {
        return [
            [666666],
            [155555],
            ['cat'],
            ['A1'],

        ];
    }

    /**
     * @test
     * @dataProvider invalidDateFrecuencyProvider
     */
    public function throw_date_frecuency_is_invalid($dateFrecuency)
    {
        $this->expectExceptionMessage("Date frecuency is not valid.");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setDateFrecuency($dateFrecuency);
    }

    /**
     * @test
     */
    public function charge_expiry_date_is_valid()
    {
        $redsys = new Tpv();
        $redsys->setChargeExpiryDate('2025-03-04');
        $parameters = $redsys->getParameters();

        $this->assertArrayHasKey('DS_MERCHANT_CHARGEEXPIRYDATE', $parameters);
    }

    public function invalidChargeExpiryDateProvider()
    {
        return [
            ['2024-13-04'],
            ['04-03-81'],
            ['01-05-2019'],
            ['00-00-00'],
            ['03-21-19'],
            ['10-21-2022'],
            ['22-06-29'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidChargeExpiryDateProvider
     */
    public function throw_charge_expiry_date_is_invalid($date)
    {
        $this->expectExceptionMessage("Date is not valid.");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setChargeExpiryDate($date);
    }


    public function invalidOrderNumberProvider()
    {
        return [
            ['A-001'],
            ['13A'],
            ['53N'],
            ['--00DA34'],
            ['3656745676711'],
            [date('YmdHis')],
            ['111'],
            [22],
            ['/*()$"%()!·%']
        ];
    }

    /**
     * @test
     * @dataProvider invalidOrderNumberProvider
     */
    public function throw_when_order_is_invalid($orderNumber)
    {
        $this->expectExceptionMessage("Order id must be a 4 digit string at least, maximum 12 characters.");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setOrder($orderNumber);

    }

    public function orderNumberProvider()
    {
        return [
            [100253508],
            ['200065'],
            ['0001-A45'],
            ['9834BC-001'],
            ['300004A'],
            ['4000-H001-A'],
            ['ACAR00001120'],
            ['5A7000000001']
        ];
    }

    /**
     *
     * @test
     * @dataProvider orderNumberProvider
     */
    public function should_validate_an_order_number($order)
    {
        $redsys = new Tpv();
        $redsys->setOrder($order);
        $parameters = $redsys->getParameters();
        $this->assertArrayHasKey('DS_MERCHANT_ORDER', $parameters);
    }

    /**
     * @test
     */
    public function throw_merchant_code_is_empty()
    {
        $this->expectExceptionMessage("Please add Fuc");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setMerchantcode();
    }

    /**
     * @test
     */
    public function throw_currency_is_not_supported()
    {
        $this->expectExceptionMessage("Currency is not valid");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setCurrency('csm');
    }

    /**
     * @test
     */
    public function throw_transaction_type_is_empty()
    {
        $this->expectExceptionMessage("Please add transaction type");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setTransactiontype('');
    }


    /**
     * @test
     */
    public function throw_terminal_is_invalid_number()
    {
        $this->expectExceptionMessage("Terminal is not valid.");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setTerminal('0');
    }

    /**
     * @test
     */
    public function throw_environment_is_not_test_or_live()
    {
        $this->expectExceptionMessage("Add test or live");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setEnvironment('production');


    }

    public function SearchingFormProvider()
    {
        return [
            ['Ds_MerchantParameters'],
            ['Ds_Signature'],
            ['Ds_SignatureVersion'],
            ['btn_submit'],
        ];

    }

    /**
     * @test
     * @dataProvider SearchingFormProvider
     */
    public function check_if_form_create_inputs_with_parameters($search)
    {
        $redsys = new Tpv();
        $form = $redsys->createForm();
        $this->assertStringContainsString($search,$form);
    }

    /**
     * @test
     *
     */
    public function when_set_all_parameters_should_obtain_all_ds_merchant_valid()
    {
        $redsys = new Tpv();
        $redsys->setEnvironment('test')
            ->setAmount(rand(10,600))
            ->setOrder(time())
            ->setMerchantcode('999008881')
            ->setCurrency('978')
            ->setTransactiontype('0')
            ->setTerminal('1')
            ->setMethod('C')
            ->setNotification('')
            ->setUrlOk('http://localhost/ok.php')
            ->setUrlKo('http://localhost/ko.php')

            ->setEnvironment('test');
        $parameters = $redsys->getParameters();

        $this->assertArrayHasKey('DS_MERCHANT_AMOUNT', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_ORDER', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_MERCHANTCODE', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_CURRENCY', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_TRANSACTIONTYPE', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_TERMINAL', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_PAYMETHODS', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_MERCHANTURL', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_URLOK', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_URLKO', $parameters);

    }

    /**
     * @test
     */
    public function throw_version_is_empty()
    {
        $this->expectExceptionMessage("Please add version.");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setVersion();
    }


    public function urlTpvProvider()
    {
        return [
            ['live', 'https://sis.redsys.es/sis/realizarPago'],
            ['test', 'https://sis-t.redsys.es:25443/sis/realizarPago'],
            ['restLive', 'https://sis.redsys.es/sis/rest/trataPeticionREST'],
            ['restTest', 'https://sis-t.redsys.es:25443/sis/rest/trataPeticionREST'],
            ['startRequestRestLive', 'https://sis.redsys.es/sis/rest/iniciaPeticionREST'],
            ['startRequestRestTest', 'https://sis-t.redsys.es:25443/sis/rest/iniciaPeticionREST'],
        ];
    }

    /**
     * @test
     * @dataProvider urlTpvProvider
     */
    public function check_if_url_of_tpv_is_test_or_live($environment, $url)
    {
        $redsys = new Tpv();
        $redsys->setEnvironment($environment);
        $url_tpv = $redsys->getEnvironment();
        $this->assertEquals($url, $url_tpv);
    }

    /**
     * @test
     */
    public function force_to_send_the_form_with_javascript()
    {
        $redsys = new Tpv();
        $redsys->setNameForm('custom_form_'.date('His'));
        $js = 'document.forms["'.$redsys->getNameForm().'"].submit();';

        $redirect = $redsys->executeRedirection(true);

        $this->assertStringContainsString($js, $redirect);
    }

    /**
     * @test
     */
    public function throw_merchant_data_is_empty()
    {
        $this->expectExceptionMessage("Add merchant data");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setMerchantData();
    }

    /**
     * @test
     */
    public function throw_product_description_is_empty()
    {
        $this->expectExceptionMessage("Add product description");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setProductDescription();
    }

    /**
     * @test
     */
    public function throw_titular_is_empty()
    {
        $this->expectExceptionMessage("Add name for the user");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setTitular();
    }

    /**
     * @test
     */
    public function throw_trade_name_is_empty()
    {
        $this->expectExceptionMessage("Add name for Trade name");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setTradeName();
    }

    /**
     * @test
     */
    public function throw_pan_is_invalid()
    {
        $this->expectExceptionMessage("Pan not valid");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setPan(0);
    }

    public function invalidExpiryDateProvider()
    {
        return [
            ['23233'],
            [45],
            [666],
            ['a452'],
            ['564O'],
            ['aamm'],
            ['am'],
            ['236'],
        ];

    }

    /**
     * @test
     * @dataProvider invalidExpiryDateProvider
     */
    public function throw_expiry_date_is_invalid($expiry_date)
    {
        $this->expectExceptionMessage("Expire date is not valid");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setExpiryDate($expiry_date);
    }

    /**
     * @test
     */
    public function expiry_date_is_number_and_has_four_characters()
    {
        $redsys = new Tpv();
        $redsys->setExpiryDate(2012);
        $parameters = $redsys->getParameters();
        $this->assertArrayHasKey('DS_MERCHANT_EXPIRYDATE', $parameters);
    }

    /**
     * @test
     */
    public function throw_cvv2_is_invalid()
    {
        $this->expectExceptionMessage("CVV2 is not valid");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setCVV2();
    }


    public function invalidParameters()
    {
        return [
            ['23233'],
            [45],
            [666],
            [
                [100,'R'],
                ['Ds_store' => 233]
            ]
        ];

    }

    /**
     * @test
     * @dataProvider invalidParameters
     */

    public function throw_parameters_is_not_an_array($parameters)
    {
        $this->expectExceptionMessage("Parameters is not an array associative");
        $this->expectExceptionMessage("Parameters is not an array");
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();

       $redsys->setParameters($parameters);

    }

    /**
     * @test
     */

     public function set_new_parameters()
     {
        $parameters = ['DS_MERCHANT_COF_INI' => 'S', 'DS_MERCHANT_COF_TYPE' => 'R'];
        $redsys = new Tpv();
        $redsys->setParameters($parameters);

        $this->assertArrayHasKey('DS_MERCHANT_COF_INI', $parameters);
        $this->assertArrayHasKey('DS_MERCHANT_COF_TYPE', $parameters);

     }

    public function validTransactionTypeProvider(): array
    {
        return [
            'Installments' => [Tpv::INSTALLMENTS],
            'Recurring' => [Tpv::RECURRING],
            'Reauthorization' => [Tpv::REAUTHORIZATION],
            'Resubmission' => [Tpv::RESUBMISSION],
            'Delayed' => [Tpv::DELAYED],
            'Incremental' => [Tpv::INCREMENTAL],
            'No Show' => [Tpv::NO_SHOW],
            'Otras' => [Tpv::OTHER],
        ];
    }

    /**
     * @test
     * @dataProvider validTransactionTypeProvider
     */
    public function transaction_type_is_valid($type): void
    {
        $redsys = new Tpv();
        $redsys->setMerchantCofType($type);
        $ds = $redsys->getParameters();
        $this->assertEquals($type, $ds['DS_MERCHANT_COF_TYPE']);
    }



    public function invalidTransactionTypeProvider(): array
    {
        return [
            'A' => ['A'],
            'B' => ['B'],
            'F' => ['F'],
            'G' => ['G'],
            'J' => ['J'],
            'K' => ['K'],
            'L' => ['L'],
            'O' => ['O'],
            'P' => ['P'],
            'Q' => ['Q'],
            'S' => ['S'],
            'T' => ['T'],
            'U' => ['U'],
            'V' => ['V'],
            'W' => ['W'],
            'X' => ['X'],
            'Y' => ['Y'],
            'Z' => ['Z'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidTransactionTypeProvider
     */

    public function throw_when_transaction_type_is_not_valid($type): void
    {
        $this->expectExceptionMessage('Set Merchant COF type');
        $this->expectException(\Sermepa\Tpv\TpvException::class);
        $redsys = new Tpv();
        $redsys->setMerchantCofType($type);

        $redsys->setParameters($type);

    }
}
