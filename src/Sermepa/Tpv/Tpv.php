<?php

namespace Sermepa\Tpv;

use Exception;

/**
 * Class Sermepa
 */
class Tpv
{
    private $_setEnvironment;
    private $_setNameForm;
    private $_setIdForm;
    private $_setParameters;
    private $_setVersion;
    private $_setNameSubmit;
    private $_setIdSubmit;
    private $_setValueSubmit;
    private $_setStyleSubmit;
    private $_setClassSubmit;
    private $_setSignature;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setEnvironment();

        $this->_setParameters = array();
        $this->_setVersion = 'HMAC_SHA256_V1';
        $this->_setNameForm = 'redsys_form';
        $this->_setIdForm = 'redsys_form';
        $this->_setNameSubmit = 'btn_submit';
        $this->_setIdSubmit = 'btn_submit';
        $this->_setValueSubmit = 'Send';
        $this->_setStyleSubmit = '';
        $this->_setClassSubmit = '';

    }

    /************* NEW METHODS ************* */

    /**
     * Set identifier required
     *
     * @param string $value Este parámetro se utilizará para manejar la referencia asociada a los datos de tarjeta. Es
     *                      un campo alfanumérico de un máximo de 40 posiciones cuyo valor es generado por el TPV
     *                      Virtual.
     *
     * @throws TpvException
     */
    public function setIdentifier($value = 'REQUIRED')
    {
        if ($this->isEmpty($value)) {
            throw new TpvException('Please add value');
        }

        $this->_setParameters['DS_MERCHANT_IDENTIFIER'] = $value;
    }

    /**
     * @param bool $flat
     *
     * @throws TpvException
     */
    public function setMerchantDirectPayment($flat = false)
    {
        if (!is_bool($flat)) {
            throw new TpvException('Please set true or false');
        }

        $this->_setParameters['DS_MERCHANT_DIRECTPAYMENT '] = $flat;
    }

    /**
     * Set amount (required)
     *
     * @param $amount
     *
     * @throws TpvException
     */
    public function setAmount($amount)
    {
        if ($amount < 0) {
            throw new TpvException('Amount must be greater than or equal to 0.');
        }

        $amount = $this->convertNumber($amount);
        $amount = intval(strval($amount * 100));

        $this->_setParameters['DS_MERCHANT_AMOUNT'] = $amount;
    }

    /**
     * Set Order number - [The first 4 digits must be numeric.] (required)
     *
     * @param $order
     *
     * @throws TpvException
     */
    public function setOrder($order)
    {
        $order = trim($order);
        if (strlen($order) <= 0 || strlen($order) > 12 || !is_numeric(substr($order, 0, 4))) {
            throw new TpvException('Order id must be a 4 digit string at least, maximum 12 characters.');
        }

        $this->_setParameters['DS_MERCHANT_ORDER'] = $order;
    }

    /**
     * Get order
     *
     * @return mixed
     */
    public function getOrder()
    {
        return $this->_setParameters['DS_MERCHANT_ORDER'];
    }

    /**
     * Get Ds_Order of Notification
     *
     * @param array $parameters Array with parameters
     *
     * @return string
     */
    public function getOrderNotification($parameters)
    {
        $order = '';
        foreach ($parameters as $key => $value) {
            if (strtolower($key) === 'ds_order') {
                $order = $value;
            }
        }

        return $order;
    }

    /**
     * Set code Fuc of trade (required)
     *
     * @param string $fuc Fuc
     *
     * @throws TpvException
     */
    public function setMerchantcode($fuc)
    {
        if ($this->isEmpty($fuc)) {
            throw new TpvException('Please add Fuc');
        }

        $this->_setParameters['DS_MERCHANT_MERCHANTCODE'] = $fuc;
    }

    /**
     * Set currency
     *
     * @param int $currency 978 para Euros, 840 para Dólares, 826 para libras esterlinas y 392 para Yenes.
     *
     * @throws TpvException
     */
    public function setCurrency($currency = 978)
    {
        if ($currency != '978' && $currency != '840' && $currency != '826' && $currency != '392') {
            throw new TpvException('Currency is not valid');
        }

        $this->_setParameters['DS_MERCHANT_CURRENCY'] = $currency;
    }

    /**
     * Set Transaction type
     *
     * @param int $transaction
     *
     * @throws TpvException
     */
    public function setTransactiontype($transaction = 0)
    {
        if ($this->isEmpty($transaction)) {
            throw new TpvException('Please add transaction type');
        }

        $this->_setParameters['DS_MERCHANT_TRANSACTIONTYPE'] = $transaction;
    }

    /**
     * Set terminal by default is 1 to  Sadabell(required)
     *
     * @param int $terminal
     *
     * @throws TpvException
     */
    public function setTerminal($terminal = 1)
    {
        if (intval($terminal) === 0) {
            throw new TpvException('Terminal is not valid.');
        }

        $this->_setParameters['DS_MERCHANT_TERMINAL'] = $terminal;
    }

    /**
     * Set url notification
     *
     * @param string $url
     */
    public function setNotification($url = '')
    {
        $this->_setParameters['DS_MERCHANT_MERCHANTURL'] = $url;
    }

    /**
     * Set url Ok
     *
     * @param string $url
     */
    public function setUrlOk($url = '')
    {
        $this->_setParameters['DS_MERCHANT_URLOK'] = $url;
    }

    /**
     * Set url Ko
     *
     * @param string $url
     */
    public function setUrlKo($url = '')
    {
        $this->_setParameters['DS_MERCHANT_URLKO'] = $url;
    }

    /**
     * @param string $version
     */
    public function setVersion($version = '')
    {
        $this->_setVersion = $version;
    }

    /**
     * Generate Merchant Parameters
     *
     * @return string
     */
    public function generateMerchantParameters()
    {
        //Convert Array to Json
        $json = $this->arrayToJson($this->_setParameters);

        //Return Json to Base64
        return $this->encodeBase64($json);
    }

    /**
     * Generate Merchant Signature
     *
     * @param string $key
     *
     * @return string
     */
    public function generateMerchantSignature($key)
    {
        $key = $this->decodeBase64($key);
        //Generate Merchant Parameters
        $merchant_parameter = $this->generateMerchantParameters();
        // Get key with Order and key
        $key = $this->encrypt_3DES($this->getOrder(), $key);
        // Generated Hmac256 of Merchant Parameter
        $result = $this->hmac256($merchant_parameter, $key);

        // Base64 encoding
        return $this->encodeBase64($result);
    }

    /**
     * Generate Merchant Signature Notification
     *
     * @param string $key
     * @param string $data
     *
     * @return string
     */
    public function generateMerchantSignatureNotification($key, $data)
    {
        $key = $this->decodeBase64($key);
        // Decode data base64
        $decode = $this->base64_url_decode($data);
        // Los datos decodificados se pasan al array de datos
        $parameters = $this->JsonToArray($decode);
        $order = $this->getOrderNotification($parameters);

        $key = $this->encrypt_3DES($order, $key);
        // Generated Hmac256 of Merchant Parameter
        $result = $this->hmac256($data, $key);

        return $this->base64_url_encode($result);
    }

    /**
     * Set Merchant Signature
     *
     * @param string $signature
     */
    public function setMerchantSignature($signature)
    {
        $this->_setSignature = $signature;
    }

    /**
     * Set enviroment
     *
     * @param string $environment test or live
     *
     * @throws Exception
     */
    public function setEnvironment($environment = 'test')
    {
        $environment = trim($environment);
        if ($environment === 'live') {
            //Live
            $this->_setEnvironment = 'https://sis.redsys.es/sis/realizarPago';
        } elseif ($environment === 'test') {
            //Test
            $this->_setEnvironment = 'https://sis-t.redsys.es:25443/sis/realizarPago';
        } else {
            throw new TpvException('Add test or live');
        }
    }

    /**
     * @param string $environment
     * @deprecated Use `setEnvironment`
     */
    public function setEnviroment($environment = 'test')
    {
        $this->setEnvironment($environment);
    }

    /**
     * Set language code by default 001 = Spanish
     *
     * @param string $languageCode Language code [Castellano-001, Inglés-002, Catalán-003, Francés-004, Alemán-005,
     *                             Holandés-006, Italiano-007, Sueco-008, Portugués-009, Valenciano-010, Polaco-011,
     *                             Gallego-012 y Euskera-013.]
     *
     * @throws Exception
     */
    public function setLanguage($languageCode = '001')
    {
        if ($this->isEmpty($languageCode)) {
            throw new TpvException('Add language code');
        }

        $this->_setParameters['DS_MERCHANT_CONSUMERLANGUAGE'] = trim($languageCode);
    }

    /**
     * Return enviroment
     *
     * @return string Url of enviroment
     */
    public function getEnviroment()
    {
        return $this->_setEnvironment;
    }

    /**
     * Optional field for the trade to be included in the data sent by the "on-line" response to trade if this option
     * has been chosen.
     *
     * @param string $merchantdata
     *
     * @throws Exception
     */
    public function setMerchantData($merchantdata)
    {
        if ($this->isEmpty($merchantdata)) {
            throw new TpvException('Add merchant data');
        }

        $this->_setParameters['DS_MERCHANT_MERCHANTDATA'] = trim($merchantdata);
    }

    /**
     * Set product description (optional)
     *
     * @param string $description
     *
     * @throws Exception
     */
    public function setProductDescription($description = '')
    {
        if ($this->isEmpty($description)) {
            throw new TpvException('Add product description');
        }

        $this->_setParameters['DS_MERCHANT_PRODUCTDESCRIPTION'] = trim($description);
    }

    /**
     * Set name of the user making the purchase (required)
     *
     * @param string $titular name of the user (for example Alonso Cotos)
     *
     * @throws Exception
     */
    public function setTitular($titular = '')
    {
        if ($this->isEmpty($titular)) {
            throw new TpvException('Add name for the user');
        }

        $this->_setParameters['DS_MERCHANT_TITULAR'] = trim($titular);
    }

    /**
     * Set Trade name Trade name will be reflected in the ticket trade (Optional)
     *
     * @param string $tradename trade name
     *
     * @throws Exception
     */
    public function setTradeName($tradename = '')
    {
        if ($this->isEmpty($tradename)) {
            throw new TpvException('Add name for Trade name');
        }

        $this->_setParameters['DS_MERCHANT_MERCHANTNAME'] = trim($tradename);
    }

    /**
     * Payment type
     *
     * @param string $method [T = Pago con Tarjeta + iupay , R = Pago por Transferencia, D = Domiciliacion, C = Sólo
     *                       Tarjeta (mostrará sólo el formulario para datos de tarjeta)] por defecto es T
     *
     * @throws Exception
     */
    public function setMethod($method = 'T')
    {
        if ($this->isEmpty($method)) {
            throw new TpvException('Add pay method');
        }

        $this->_setParameters['DS_MERCHANT_PAYMETHODS'] = trim($method);
    }

    /**
     * Card number
     *
     * @param string $pan Tarjeta. Su longitud depende del tipo de tarjeta.
     *
     * @throws TpvException
     */
    public function setPan($pan)
    {
        if (intval($pan) == 0) {
            throw new TpvException('Pan not valid');
        }

        $this->_setParameters['DS_MERCHANT_PAN'] = $pan;
    }

    /**
     * Expire date
     *
     * @param $expirydate . Caducidad de la tarjeta. Su formato es AAMM, siendo AA los dos últimos dígitos del año y MM
     *                    los dos dígitos del mes.
     *
     * @throws TpvException
     */
    public function setExpiryDate($expirydate)
    {
        if (strlen($expirydate) != 4) {
            throw new TpvException('Expire date is not valid');
        }

        $this->_setParameters['DS_MERCHANT_EXPIRYDATE'] = $expirydate;
    }

    /**
     * CVV2 card
     *
     * @param string $cvv2 Código CVV2 de la tarjeta
     *
     * @throws TpvException
     */
    public function setCVV2($cvv2)
    {
        if (intval($cvv2) == 0) {
            throw new TpvException('CVV2 is not valid');
        }

        $this->_setParameters['DS_MERCHANT_CVV2'] = $cvv2;
    }

    /**
     * Set name to form
     *
     * @param string $name Name for form.
     */
    public function setNameForm($name = 'servired_form')
    {
        $this->_setNameForm = $name;
    }

    /**
     * Set Id to form
     *
     * @param string $id Name for Id
     */
    public function setIdForm($id = 'servired_form')
    {
        $this->_setIdForm = $id;
    }

    /**
     * Set Attributes to submit
     *
     * @param string $name     Name submit
     * @param string $id       Id submit
     * @param string $value    Value submit
     * @param string $style    Set Style
     * @param string $cssClass CSS class
     */
    public function setAttributesSubmit(
        $name = 'btn_submit',
        $id = 'btn_submit',
        $value = 'Send',
        $style = '',
        $cssClass = ''
    ) {
        $this->_setNameSubmit = $name;
        $this->_setIdSubmit = $id;
        $this->_setValueSubmit = $value;
        $this->_setStyleSubmit = $style;
        $this->_setClassSubmit = $cssClass;
    }

    /**
     * Execute redirection to TPV
     *
     * @return string|null
     */
    public function executeRedirection($return = false)
    {
        $html = $this->createForm();
        $html .= '<script>document.forms["'.$this->_setNameForm.'"].submit();</script>';

        if (!$return) {
            echo $html;

            return null;
        }

        return $html;
    }

    /**
     * Generate form html
     *
     * @return string
     */
    public function createForm()
    {
        $form = '
            <form action="'.$this->_setEnvironment.'" method="post" id="'.$this->_setIdForm.'" name="'.$this->_setNameForm.'" >
                <input type="hidden" name="Ds_MerchantParameters" value="'.$this->generateMerchantParameters().'"/>
                <input type="hidden" name="Ds_Signature" value="'.$this->_setSignature.'"/>
                <input type="hidden" name="Ds_SignatureVersion" value="'.$this->_setVersion.'"/>
                <input type="submit" name="'.$this->_setNameSubmit.'" id="'.$this->_setIdSubmit.'" value="'.$this->_setValueSubmit.'" '.($this->_setStyleSubmit != '' ? ' style="'.$this->_setStyleSubmit.'"' : '').' '.($this->_setClassSubmit != '' ? ' class="'.$this->_setClassSubmit.'"' : '').'>
            </form>
        ';

        return $form;
    }

    /**
     * Check if properly made ​​the purchase.
     *
     * @param string $key      Key
     * @param array  $postData Data received by the bank
     *
     * @return bool
     * @throws TpvException
     */
    public function check($key = '', $postData)
    {
        if (!isset($postData)) {
            throw new TpvException("Add data return of bank");
        }

        $version = $postData["Ds_SignatureVersion"];
        $parameters = $postData["Ds_MerchantParameters"];
        $signatureReceived = $postData["Ds_Signature"];

        $decodec = $this->decodeParameters($parameters);
        $signature = $this->generateMerchantSignatureNotification($key, $parameters);

        return ($signature === $signatureReceived);
    }

    /**
     *  Decode Ds_MerchantParameters, return array with the parameters
     *
     * @param $parameters
     *
     * @return array with parameters of bank
     */
    public function getMerchantParameters($parameters)
    {
        $decoded = $this->decodeParameters($parameters);

        return $this->JsonToArray($decoded);
    }

    /**
     * Return array with all parameters assigned.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->_setParameters;
    }

    /**
     * Return version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_setVersion;
    }

    /**
     * Return MerchantSignature
     *
     * @return string
     */
    public function getMerchantSignature()
    {
        return $this->_setSignature;
    }

    // ******** UTILS ********

    /**
     * Convert Array to json
     *
     * @param array $data Array
     *
     * @return string Json
     */
    private function arrayToJson($data)
    {
        return json_encode($data);
    }

    /**
     * Convert Json to array
     *
     * @param string $data
     *
     * @return mixed
     */
    private function JsonToArray($data)
    {
        return json_decode($data, true);
    }

    /**
     * Generate sha256
     *
     * @param string $data
     * @param string $key
     *
     * @return string
     */
    private function hmac256($data, $key)
    {
        return hash_hmac('sha256', $data, $key, true);
    }

    /**
     * Encrypt to 3DES
     *
     * @param string $data Data for encrypt
     * @param string $key  Key
     *
     * @return string
     */
    private function encrypt_3DES($data, $key)
    {
        $iv = "\0\0\0\0\0\0\0\0";
        $data_padded = $data;

        if (strlen($data_padded) % 8) {
            $data_padded = str_pad($data_padded, strlen($data_padded) + 8 - strlen($data_padded) % 8, "\0");
        }

        return openssl_encrypt($data_padded, "DES-EDE3-CBC", $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
    }

    /**
     * @param string $data
     *
     * @return bool|string
     */
    private function decodeParameters($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * @param string $value
     *
     * @return int
     */
    protected function isEmpty($value)
    {
        return '' === trim($value);
    }

    //http://stackoverflow.com/a/9111049/444225
    private function priceToSQL($price)
    {
        $price = preg_replace('/[^0-9\.,]*/i', '', $price);
        $price = str_replace(',', '.', $price);
        if (substr($price, -3, 1) === '.') {
            $price = explode('.', $price);
            $last = array_pop($price);
            $price = join($price, '').'.'.$last;
        } else {
            $price = str_replace('.', '', $price);
        }

        return $price;
    }

    /**
     * @param mixed $price
     *
     * @return string
     */
    private function convertNumber($price)
    {
        return number_format(str_replace(',', '.', $price), 2, '.', '');
    }

    /******  Base64 Functions  *****
     *
     * @param string $input
     *
     * @return string
     */
    private function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    /**
     * @param string $data
     *
     * @return string
     */
    private function encodeBase64($data)
    {
        return base64_encode($data);
    }

    /**
     * @param string $input
     *
     * @return string
     */
    private function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * @param string $data
     *
     * @return string
     */
    private function decodeBase64($data)
    {
        return base64_decode($data);
    }

    // ******** END UTILS ********
}
