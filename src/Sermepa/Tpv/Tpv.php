<?php

namespace Sermepa\Tpv;

use Exception;

/**
 * Class Sermepa
 */
class Tpv
{
    CONST TIMEOUT = 10;
    CONST READ_TIMEOUT = 120;
    CONST SSLVERSION_TLSv1_2 = 6;

    protected $_setEnvironment;
    protected $_setNameForm;
    protected $_setIdForm;
    protected $_setParameters;
    protected $_setVersion;
    protected $_setNameSubmit;
    protected $_setIdSubmit;
    protected $_setValueSubmit;
    protected $_setStyleSubmit;
    protected $_setClassSubmit;
    protected $_setSignature;

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
     * @return $this
     * @throws TpvException
     */
    public function setIdentifier($value = 'REQUIRED')
    {
        if ($this->isEmpty($value)) {
            throw new TpvException('Please add value');
        }

        $this->_setParameters['DS_MERCHANT_IDENTIFIER'] = $value;

        return $this;
    }

    /**
     * @param bool $flat
     *
     * @return $this
     * @throws TpvException
     */
    public function setMerchantDirectPayment($flat = false)
    {
        if (!is_bool($flat)) {
            throw new TpvException('Please set true or false');
        }

        $this->_setParameters['DS_MERCHANT_DIRECTPAYMENT'] = $flat;

        return $this;
    }

    /**
     * Set amount (required)
     *
     * @param $amount
     *
     * @return $this
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

        return $this;
    }

    /**
     * Set Sum total (required for recurring payment)
     *
     * @param $sumTotal
     *
     * @return $this
     * @throws TpvException
     */
    public function setSumtotal($sumTotal)
    {
        if ($sumTotal < 0) {
            throw new TpvException('Sum total must be greater than or equal to 0.');
        }

        $sumTotal = $this->convertNumber($sumTotal);
        $sumTotal = intval(strval($sumTotal * 100));

        $this->_setParameters['DS_MERCHANT_SUMTOTAL'] = $sumTotal;

        return $this;
    }


    /**
     * Set Charge expiry date (required for recurring payment)
     *
     * @param $date
     *
     * @return $this
     * @throws TpvException
     */
    public function setChargeExpiryDate($date)
    {
        if ( ! $this->isValidDate($date) ) {
            throw new TpvException('Date is not valid.');
        }

        $this->_setParameters['DS_MERCHANT_CHARGEEXPIRYDATE'] = $date;

        return $this;
    }

    /**
     * Set Date frecuency (required for recurring payment)
     *
     * @param $dateFrecuency
     *
     * @return $this
     * @throws TpvException
     */
    public function setDateFrecuency($dateFrecuency)
    {
        if ( !is_numeric($dateFrecuency) || (strlen($dateFrecuency) < 1 || strlen($dateFrecuency) > 5) ) {
            throw new TpvException('Date frecuency is not valid.');
        }

        $this->_setParameters['DS_MERCHANT_DATEFRECUENCY'] = $dateFrecuency;

        return $this;
    }



    /**
     * Set Order number - [The first 4 digits must be numeric.] (required)
     *
     * @param $order
     *
     * @return $this
     * @throws TpvException
     */
    public function setOrder($order='')
    {
        $order = trim($order);
        if (strlen($order) <= 3 || strlen($order) > 12 || !preg_match('/^[\w\.]+$/', substr($order, 0, 4))) {
            throw new TpvException('Order id must be a 4 digit string at least, maximum 12 characters.');
        }

        $this->_setParameters['DS_MERCHANT_ORDER'] = $order;

        return $this;
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
     * @return $this
     * @throws TpvException
     */
    public function setMerchantcode($fuc='')
    {
        if ($this->isEmpty($fuc)) {
            throw new TpvException('Please add Fuc');
        }

        $this->_setParameters['DS_MERCHANT_MERCHANTCODE'] = $fuc;

        return $this;
    }

    /**
     * Set currency
     *
     * @param int $currency Algunos ejemplos: 978 para Euros, 840 para Dólares, 826 para libras esterlinas y 392 para Yenes.
     *
     * @return $this
     * @throws TpvException
     */
    public function setCurrency($currency = 978)
    {
        if (!preg_match('/^[0-9]{3}$/', $currency)) {
            throw new TpvException('Currency is not valid');
        }

        $this->_setParameters['DS_MERCHANT_CURRENCY'] = $currency;

        return $this;
    }

    /**
     * Set Transaction type
     *
     * @param int $transaction
     *
     * @return $this
     * @throws TpvException
     */
    public function setTransactiontype($transaction = 0)
    {
        if ($this->isEmpty($transaction)) {
            throw new TpvException('Please add transaction type');
        }

        $this->_setParameters['DS_MERCHANT_TRANSACTIONTYPE'] = $transaction;

        return $this;
    }

    /**
     * Set terminal by default is 1 to  Sadabell(required)
     *
     * @param int $terminal
     *
     * @return $this
     * @throws TpvException
     */
    public function setTerminal($terminal = 1)
    {
        if (intval($terminal) === 0) {
            throw new TpvException('Terminal is not valid.');
        }

        $this->_setParameters['DS_MERCHANT_TERMINAL'] = $terminal;

        return $this;
    }

    /**
     * Set url notification
     *
     * @param string $url
     * @return $this
     */
    public function setNotification($url = '')
    {
        $this->_setParameters['DS_MERCHANT_MERCHANTURL'] = $url;

        return $this;
    }

    /**
     * Set url Ok
     *
     * @param string $url
     * @return $this
     */
    public function setUrlOk($url = '')
    {
        $this->_setParameters['DS_MERCHANT_URLOK'] = $url;

        return $this;
    }

    /**
     * Set url Ko
     *
     * @param string $url
     * @return $this
     */
    public function setUrlKo($url = '')
    {
        $this->_setParameters['DS_MERCHANT_URLKO'] = $url;

        return $this;
    }

    /**
     * @param string $version
     * @return $this
     * @throws TpvException
     */
    public function setVersion($version = '')
    {
        if ($this->isEmpty($version)) {
            throw new TpvException('Please add version.');
        }
        $this->_setVersion = $version;

        return $this;
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
     * @return $this
     */
    public function setMerchantSignature($signature)
    {
        $this->_setSignature = $signature;

        return $this;
    }

    /**
     * Set environment
     *
     * @param string $environment test or live
     *
     * @return $this
     * @throws TpvException
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
        } elseif ($environment === 'restLive' || $environment === 'manageRequestRestLive') {
            //Rest Live
            $this->_setEnvironment = 'https://sis.redsys.es/sis/rest/trataPeticionREST';
        } elseif ($environment === 'restTest' || $environment === 'manageRequestRestTest' ) {
            //Rest Test
            $this->_setEnvironment = 'https://sis-t.redsys.es:25443/sis/rest/trataPeticionREST';
        } elseif ($environment === 'startRequestRestLive') {
            //Start request
            $this->_setEnvironment = 'https://sis.redsys.es/sis/rest/iniciaPeticionREST';
        } elseif ($environment === 'startRequestRestTest') {
            //Start request test
            $this->_setEnvironment = 'https://sis-t.redsys.es:25443/sis/rest/iniciaPeticionREST';
        } else {
            throw new TpvException('Add test or live');
        }

        return $this;
    }

    /**
     * @param string $environment
     * @throws TpvException
     * @deprecated Use `setEnvironment`
     * @return $this
     */
    public function setEnviroment($environment = 'test')
    {
        $this->setEnvironment($environment);

        return $this;
    }

    /**
     * Set language code by default 001 = Spanish
     *
     * @param string $languageCode Language code [Castellano-001, Inglés-002, Catalán-003, Francés-004, Alemán-005,
     *                             Holandés-006, Italiano-007, Sueco-008, Portugués-009, Valenciano-010, Polaco-011,
     *                             Gallego-012 y Euskera-013.]
     *
     * @return $this
     * @throws Exception
     */
    public function setLanguage($languageCode = '001')
    {
        if ($this->isEmpty($languageCode)) {
            throw new TpvException('Add language code');
        }

        $this->_setParameters['DS_MERCHANT_CONSUMERLANGUAGE'] = trim($languageCode);

        return $this;
    }

    /**
     * Return environment
     * @deprecated Use `getEnvironment`
     * @return string Url of environment
     */
    public function getEnviroment()
    {
        return $this->getEnvironment();
    }

    /**
     * Return environment
     *
     * @return string Url of environment
     */
    public function getEnvironment()
    {
        return $this->_setEnvironment;
    }

    /**
     * Returns the path to the Redsys JavaScript file for the specified environment and version.
     *
     * @param string $environment Environment: test or live.
     * @param string $version JavaScript file version: 2 or 3.
     * @return string JavaScript file path.
     */
    public static function getJsPath($environment = 'test', $version = '2'){

        // Stores the array of JavaScript file paths.
        static $jsPaths = [
            'test' => [
                '2' => 'https://sis-t.redsys.es:25443/sis/NC/sandbox/redsysV2.js',
                '3' => 'https://sis-t.redsys.es:25443/sis/NC/sandbox/redsysV3.js',
            ],
            'live' => [
                '2' => 'https://sis.redsys.es/sis/NC/redsysV2.js',
                '3' => 'https://sis.redsys.es/sis/NC/redsysV3.js',
            ],
        ];

        // Checks if the environment and version are valid.
        if (!isset($jsPaths[$environment][$version])) {
            throw new TpvException('Invalid environment or version');
        }

        // Returns the JavaScript file path.
        return $jsPaths[$environment][$version];
    }

    /**
     * Optional field for the trade to be included in the data sent by the "on-line" response to trade if this option
     * has been chosen.
     *
     * @param string $merchantdata
     *
     * @return $this
     * @throws Exception
     */
    public function setMerchantData($merchantdata='')
    {
        if ($this->isEmpty($merchantdata)) {
            throw new TpvException('Add merchant data');
        }

        $this->_setParameters['DS_MERCHANT_MERCHANTDATA'] = trim($merchantdata);

        return $this;
    }

    /**
     * Set product description (optional)
     *
     * @param string $description
     *
     * @return $this
     * @throws Exception
     */
    public function setProductDescription($description = '')
    {
        if ($this->isEmpty($description)) {
            throw new TpvException('Add product description');
        }

        $this->_setParameters['DS_MERCHANT_PRODUCTDESCRIPTION'] = trim($description);

        return $this;
    }

    /**
     * Set name of the user making the purchase (required)
     *
     * @param string $titular name of the user (for example Alonso Cotos)
     *
     * @return $this
     * @throws Exception
     */
    public function setTitular($titular = '')
    {
        if ($this->isEmpty($titular)) {
            throw new TpvException('Add name for the user');
        }

        $this->_setParameters['DS_MERCHANT_TITULAR'] = trim($titular);

        return $this;
    }

    /**
     * Set Trade name Trade name will be reflected in the ticket trade (Optional)
     *
     * @param string $tradename trade name
     *
     * @return $this
     * @throws Exception
     */
    public function setTradeName($tradename = '')
    {
        if ($this->isEmpty($tradename)) {
            throw new TpvException('Add name for Trade name');
        }

        $this->_setParameters['DS_MERCHANT_MERCHANTNAME'] = trim($tradename);

        return $this;
    }

    /**
     * Payment type
     *
     * @param string $method
     * [
     *      T o C = Sólo Tarjeta (mostrará sólo el formulario para datos de tarjeta)
     *      R = Pago por Transferencia,
     *      D = Domiciliación
     *      z = Bizum
     *      p = PayPal
     *      N = Masterpass
     *      xpay = GooglePay y ApplePay
     * ]
     *
     * @return $this
     * @throws Exception
     */
    public function setMethod($method = 'C')
    {
        if ($this->isEmpty($method)) {
            throw new TpvException('Add pay method');
        }

        if (!in_array($method, ['T', 'C', 'R', 'D', 'z', 'p', 'N', 'xpay'])) {
            throw new TpvException('Pay method is not valid');
        }

        $this->_setParameters['DS_MERCHANT_PAYMETHODS'] = trim($method);

        return $this;
    }

    /**
     * Card number
     *
     * @param string $pan Tarjeta. Su longitud depende del tipo de tarjeta.
     *
     * @return $this
     * @throws TpvException
     */
    public function setPan($pan=0)
    {
        if (intval($pan) === 0) {
            throw new TpvException('Pan not valid');
        }

        $this->_setParameters['DS_MERCHANT_PAN'] = $pan;

        return $this;
    }

    /**
     * Expire date
     *
     * @param $expirydate . Caducidad de la tarjeta. Su formato es AAMM, siendo AA los dos últimos dígitos del año y MM
     *                    los dos dígitos del mes.
     *
     * @return $this
     * @throws TpvException
     */
    public function setExpiryDate($expirydate='')
    {
        if ( !$this->isExpiryDate($expirydate) ) {
            throw new TpvException('Expire date is not valid');
        }
        $this->_setParameters['DS_MERCHANT_EXPIRYDATE'] = $expirydate;
        return $this;

    }

    /**
     * Set parameters
     *
     * @param array $parameters
     * @return $this
     * @throws TpvException
     */

    public function setParameters($parameters=[])
    {
        if(!is_array($parameters)) {
            throw new TpvException('Parameters is not an array');
        }

        $keys = array_keys($parameters);

        if(array_keys($keys) === $keys ) {
            throw new TpvException('Parameters is not an array associative');
        }

        $parameters = array_change_key_case($parameters, CASE_UPPER);
        $this->_setParameters = array_merge($this->_setParameters, $parameters);
        return $this;
    }

    /**
     * CVV2 card
     *
     * @param string $cvv2 Código CVV2 de la tarjeta
     *
     * @return $this
     * @throws TpvException
     */
    public function setCVV2($cvv2=0)
    {
        if (intval($cvv2) === 0) {
            throw new TpvException('CVV2 is not valid');
        }

        $this->_setParameters['DS_MERCHANT_CVV2'] = $cvv2;

        return $this;
    }

    /**
     * Set name to form
     *
     * @param string $name Name for form.
     * @return $this
     */
    public function setNameForm($name = 'servired_form')
    {
        $this->_setNameForm = $name;

        return $this;
    }

    /**
     * Get name form
     *
     * @return string
     */
    public function getNameForm()
    {
        return $this->_setNameForm;
    }

    /**
     * Set Id to form
     *
     * @param string $id Name for Id
     * @return $this
     */
    public function setIdForm($id = 'servired_form')
    {
        $this->_setIdForm = $id;

        return $this;
    }

    /**
     * Set Attributes to submit
     *
     * @param string $name Name submit
     * @param string $id Id submit
     * @param string $value Value submit
     * @param string $style Set Style
     * @param string $cssClass CSS class
     * @return $this
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

        return $this;
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
     * Send data
     */
    public function send()
    {
        $data['Ds_MerchantParameters'] = $this->generateMerchantParameters();
        $data['Ds_Signature'] = $this->_setSignature;
        $data['Ds_SignatureVersion'] = $this->_setVersion;

        $jsonCode = json_encode($data);

        $rest = curl_init ();
        curl_setopt ($rest, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt ( $rest, CURLOPT_URL, $this->_setEnvironment );
        curl_setopt ( $rest, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT );
        curl_setopt ( $rest, CURLOPT_TIMEOUT, self::READ_TIMEOUT );
        curl_setopt ( $rest, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $rest, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt ( $rest, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt ( $rest, CURLOPT_SSLVERSION, self::SSLVERSION_TLSv1_2 );
        curl_setopt ( $rest, CURLOPT_POST, true );
        curl_setopt ( $rest, CURLOPT_POSTFIELDS, $jsonCode );

        $tmp = curl_exec ( $rest );
        $httpCode=curl_getinfo($rest,CURLINFO_HTTP_CODE);

        if($tmp !== false && $httpCode==200){
            $result=$tmp;
        }
        else{
            $strError="Request failure ".(($httpCode!=200)?"[HttpCode: '".$httpCode."']":"").((curl_error($rest))?" [Error: '".curl_error($rest)."']":"");
            exit($strError);
        }

        curl_close( $rest );

        return $result;
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
    public function check($key, $postData)
    {
        if (!isset($postData)) {
            throw new TpvException("Add data return of bank");
        }

        $parameters = $postData["Ds_MerchantParameters"];
        $signatureReceived = $postData["Ds_Signature"];
        $signature = $this->generateMerchantSignatureNotification($key, $parameters);

        return hash_equals($signature, $signatureReceived);
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

    /**
     * COF Transition Indicator.
     * Mandatory for COF Visa and MC operations.
     * Possible values:
     * “S”: It is first COF transaction (store credentials)
     * “N”: It is not the first COF transaction
     *
     * @return $this
     * @throws Exception
     */
    public function setMerchantCofIni($isFirstTransaction)
    {
        $this->_setParameters['DS_MERCHANT_COF_INI'] = $isFirstTransaction ? 'S' : 'N';

        return $this;
    }

    /**
     * COF transaction type. Optional for COF Visa and MC.
     * Possible values:
     * “I”: Installments “R”: Recurring
     * “H”: Reauthorization “E”: Resubmission “D”: Delayed
     * “M”: Incremental “N”: No Show
     * “C”: Otras
     *
     * @return $this
     * @throws TpvException
     */
    public function setMerchantCofType($value)
    {
        $validOptions = ['I', 'R', 'H', 'E', 'D', 'M', 'N', 'C'];
        $value = strtoupper($value);
        if (!in_array($value, $validOptions, true)) {
            throw new TpvException('Set Merchant COF type');
        }
        $this->_setParameters['DS_MERCHANT_COF_TYPE'] = $value;

        return $this;
    }

    /**
     * COF identifier identifier. Optional. This
     * identifier is returned in the answer of the first
     * COF (store credentials) operation and
     * we must send in successive transactions made
     * with the credentials that generated this same Id_txn
     *
     * @return $this
     */
    public function setMerchantCofTxnid($txid)
    {
        if($txid) {
        $this->_setParameters['DS_MERCHANT_COF_TXNID'] = $txid;
        }
        return $this;
    }

    // ******** UTILS ********

    /**
     * Convert Array to json
     *
     * @param array $data Array
     *
     * @return string Json
     */
    protected function arrayToJson($data)
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
    protected function JsonToArray($data)
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
    protected function hmac256($data, $key)
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
    protected function encrypt_3DES($data, $key)
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
    protected function decodeParameters($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isEmpty($value)
    {
        return '' === trim($value);
    }

    /**
     * Check if expiry date is valid
     *
     * @param string $expirydate
     * @return boolean
     */
    protected function isExpiryDate($expirydate='')
    {
        return (strlen(trim($expirydate)) === 4 && is_numeric($expirydate));
    }

    /**
     * Check is order is valid
     *
     * @param string $order
     * @return boolean
     */
    protected function isValidOrder($order='')
    {
        return ( strlen($order) >= 4 && strlen($order) <= 12 && preg_match('/^[\w\.]+$/', substr($order, 0, 4)) )?true:false;

    }

    /**
     * @param mixed $price
     *
     * @return string
     */
    protected function convertNumber($price)
    {
        return number_format(str_replace(',', '.', $price), 2, '.', '');
    }

    protected function isValidDate($date)
    {
        return preg_match("/^(\d{4})-(\d{1,2})-(\d{1,2})$/", $date, $m)
            ? checkdate(intval($m[2]), intval($m[3]), intval($m[1]))
            : false;
    }

    /******  Base64 Functions  *****
     *
     * @param string $input
     *
     * @return string
     */
    protected function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    /**
     * @param string $data
     *
     * @return string
     */
    protected function encodeBase64($data)
    {
        return base64_encode($data);
    }

    /**
     * @param string $input
     *
     * @return string
     */
    protected function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * @param string $data
     *
     * @return string
     */
    protected function decodeBase64($data)
    {
        return base64_decode($data);
    }

    // ******** END UTILS ********
}
