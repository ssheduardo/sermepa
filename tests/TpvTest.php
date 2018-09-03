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
        $this->assertInternalType('boolean', $ds['DS_MERCHANT_DIRECTPAYMENT']);
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



    public function invalidOrderNumberProvider()
    {
        return [
            ['A-001'],
            ['BHGF23'],
            ['13A'],
            ['53N2'],
            ['00A1'],
            ['3656745676711'],
            [date('YmdHis')],
            ['111'],
            [22]
        ];
    }

    /**
     * @test
     * @dataProvider invalidOrderNumberProvider
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Order id must be a 4 digit string at least, maximum 12 characters.
     */
    public function throw_when_order_is_invalid($orderNumber)
    {
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
            ['4000-H001-A']
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
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Please add Fuc
     */
    public function throw_merchant_code_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setMerchantcode();
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Currency is not valid
     */
    public function throw_currency_is_not_supported()
    {
        $redsys = new Tpv();
        $redsys->setCurrency('csm');
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Please add transaction type
     */
    public function throw_transaction_type_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setTransactiontype('');
    }


    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Terminal is not valid.
     */
    public function throw_terminal_is_invalid_number()
    {
        $redsys = new Tpv();
        $redsys->setTerminal('0');
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Add test or live
     */
    public function throw_environment_is_not_test_or_live()
    {
        $redsys = new Tpv();
        $redsys->setEnvironment('production');


    }

    public function SearchinFormProvider()
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
     * @dataProvider SearchinFormProvider
     */
    public function check_if_form_create_inputs_with_parameters($search)
    {
        $redsys = new Tpv();
        $form = $redsys->createForm();
        $this->assertContains($search,$form);
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
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Please add version.
     */
    public function throw_version_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setVersion();
    }


    public function urlTpvProvider()
    {
        return [
            ['live', 'https://sis.redsys.es/sis/realizarPago'],
            ['test', 'https://sis-t.redsys.es:25443/sis/realizarPago'],
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
        $url_tpv = $redsys->getEnviroment();
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

        $this->assertContains($js, $redirect);
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Add merchant data
     */
    public function throw_merchant_data_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setMerchantData();
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Add product description
     */
    public function throw_product_description_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setProductDescription();
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Add name for the user
     */
    public function throw_titular_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setTitular();
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Add name for Trade name
     */
    public function throw_trade_name_is_empty()
    {
        $redsys = new Tpv();
        $redsys->setTradeName();
    }

    /**
     * @test
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Pan not valid
     */
    public function throw_pan_is_invalid()
    {
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
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage Expire date is not valid
     */
    public function throw_expiry_date_is_invalid($expiry_date)
    {
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
     * @expectedException \Sermepa\Tpv\TpvException
     * @expectedExceptionMessage CVV2 is not valid
     */
    public function throw_cvv2_is_invalid()
    {
        $redsys = new Tpv();
        $redsys->setCVV2();
    }

}