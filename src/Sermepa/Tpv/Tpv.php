<?php
namespace Sermepa\Tpv;

use Exception;

/**
 * Class Sermepa
 */
class Tpv{

    private $_setEnviroment;
    private $_setMerchantData;
    private $_setTerminal;
    private $_setTransactionType;
    private $_setMethod;
    private $_setNameForm;
    private $_setIdForm;
    private $_setSubmit;
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
        $this->_setEnviroment='https://sis-t.redsys.es:25443/sis/realizarPago';
        $this->_setTerminal =1;
        $this->_setMerchantData = '';
        $this->_setTransactionType=0;
        $this->_setMethod='T';
        $this->_setSubmit = '';

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
     * @param string $value Este parámetro se utilizará para manejar la referencia asociada a los datos de tarjeta. Es un campo alfanumérico de un máximo de 40 posiciones cuyo valor es generado por el TPV Virtual.
     * @throws TpvException
     */
    public function setIdentifier($value='REQUIRED')
    {
        if(strlen(trim($value)) > 0){
            $this->_setParameters['DS_MERCHANT_IDENTIFIER'] = $value;
        }
        else{
            throw new TpvException('Please add value');
        }

    }

    /**
     * @param bool $flat
     *
     * @throws TpvException
     */
    public function setMerchantDirectPayment($flat=false)
    {
        if(is_bool($flat)) {
            $this->_setParameters['DS_MERCHANT_DIRECTPAYMENT '] = $flat;
        }
        else{
            throw new TpvException('Please set true or false');
        }
    }

    /**
     * Set amount (required)
     * @param $amount
     * @throws TpvException
     */
    public function setAmount($amount)
    {
        if($amount >= 0) {
            $amount = $this->convertNumber($amount);
            $amount = intval(strval($amount*100));

            $this->_setParameters['DS_MERCHANT_AMOUNT'] = $amount;
        }
        else {
            throw new TpvException('Amount must be greater than equal 0.');
        }
    }

    /**
     * Set Order number - [The first 4 digits must be numeric.] (required)
     * @param $order
     * @throws TpvException
     */
    public function setOrder($order)
    {
        $order = trim($order);
        if(strlen($order) > 0 && strlen($order) <= 12 && is_numeric(substr($order,0,4)) ){
            $this->_setParameters['DS_MERCHANT_ORDER'] = $order;
        }
        else{
            throw new TpvException('Order id must be a 4 digit string at least, maximum 12 characters.');
        }
    }

    /**
     * Get order
     * @return mixed
     */
    public function getOrder()
    {
        return $this->_setParameters['DS_MERCHANT_ORDER'];
    }


    /**
     * Get Ds_Order of Notification
     * @param $paraments Array with parameters
     * @return string
     */
    function getOrderNotification($paraments){
        $order = '';
        foreach($paraments as $key => $value) {
            if(strtolower($key) == 'ds_order' ){
                $order = $value;
            }
        }
        return $order;
    }

    /**
     * Set code Fuc of trade (required)
     * @param $fuc Fuc
     * @throws TpvException
     */
    public function setMerchantcode($fuc)
    {
        if(strlen(trim($fuc)) > 0){
            $this->_setParameters['DS_MERCHANT_MERCHANTCODE'] = $fuc;
        }
        else{
            throw new TpvException('Please add Fuc');
        }
    }

    /**
     * Set currency
     * @param int $currency 978 para Euros, 840 para Dólares, 826 para libras esterlinas y 392 para Yenes.
     * @throws TpvException
     */
    public function setCurrency($currency=978)
    {
        if($currency == '978' || $currency =='840' || $currency =='826' || $currency =='392' ){
            $this->_setParameters['DS_MERCHANT_CURRENCY'] = $currency;
        }
        else{
            throw new TpvException('Currency is not valid');
        }

    }

    /**
     * Set Transaction type
     * @param int $transaction
     * @throws TpvException
     */
    public function setTransactiontype($transaction=0)
    {
        if(strlen(trim($transaction)) > 0){
            $this->_setParameters['DS_MERCHANT_TRANSACTIONTYPE'] = $transaction;
        }
        else{
            throw new TpvException('Please add transaction type');
        }
    }

    /**
     * Set terminal by default is 1 to  Sadabell(required)
     * @param int $terminal
     * @throws TpvException
     */
    public function setTerminal($terminal=1)
    {
        if(intval($terminal) !=0){
            $this->_setParameters['DS_MERCHANT_TERMINAL'] = $terminal;
        }
        else{
            throw new TpvException('Terminal is not valid.');
        }
    }

    /**
     * Set url notification
     * @param string $url
     */
    public function setNotification($url='')
    {
        $this->_setParameters['DS_MERCHANT_MERCHANTURL'] = $url;
    }

    /**
     * Set url Ok
     * @param string $url
     */
    public function setUrlOk($url='')
    {
        $this->_setParameters['DS_MERCHANT_URLOK'] = $url;
    }

    /**
     * Set url Ko
     * @param string $url
     */
    public function setUrlKo($url='')
    {
        $this->_setParameters['DS_MERCHANT_URLKO'] = $url;
    }

    /**
     * @param string $version
     */
    public function setVersion($version='')
    {
        $this->_setVersion = $version;
    }


    /**
     * Generate Merchant Parameters
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
     * @param $key
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
     * @param $key
     * @param $data
     * @return string
     */
    public function generateMerchantSignatureNotification($key, $data){
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
     * @param $signature
     * @internal param $value
     */
    public function setMerchantSignature($signature)
    {
        $this->_setSignature = $signature;
    }


    /**
     * Set enviroment
     * @param string $enviroment test or live
     * @throws Exception
     */
    public function setEnviroment($enviroment='test')
    {
        if(trim($enviroment) == 'live'){
            //Live
            $this->_setEnviroment='https://sis.redsys.es/sis/realizarPago';
        }
        elseif(trim($enviroment) == 'test'){
            //Test
            $this->_setEnviroment ='https://sis-t.redsys.es:25443/sis/realizarPago';
        }
        else{
            throw new TpvException('Add test or live');
        }
    }


    /**
     * Set language code by default 001 = Spanish
     *
     * @param string $languagecode Language code [Castellano-001, Inglés-002, Catalán-003, Francés-004, Alemán-005, Holandés-006, Italiano-007, Sueco-008, Portugués-009, Valenciano-010, Polaco-011, Gallego-012 y Euskera-013.]
     * @throws Exception
     */
    public function setLanguage($languagecode='001')
    {
        if(strlen(trim($languagecode)) > 0){
            $this->_setParameters['DS_MERCHANT_CONSUMERLANGUAGE'] = trim($languagecode);
        }
        else{
            throw new TpvException('Add language code');
        }
    }

    /**
     * Return enviroment
     *
     * @return string Url of enviroment
     */
    public function getEnviroment()
    {
        return $this->_setEnviroment;
    }

    /**
     * Optional field for the trade to be included in the data sent by the "on-line" response to trade if this option has been chosen.
     * @param $merchantdata
     * @throws Exception
     */
    public function setMerchantData($merchantdata)
    {
        if(strlen(trim($merchantdata)) > 0){
            $this->_setParameters['DS_MERCHANT_MERCHANTDATA'] = trim($merchantdata);
        }
        else{
            throw new TpvException('Add merchant data');
        }
    }

    /**
     * Set product description (optional)
     *
     * @param string $description
     * @throws Exception
     */
    public function setProductDescription($description='')
    {
        if(strlen(trim($description)) > 0){
            $this->_setParameters['DS_MERCHANT_PRODUCTDESCRIPTION'] = trim($description);
        }
        else{
            throw new TpvException('Add product description');
        }
    }

    /**
     * Set name of the user making the purchase (required)
     *
     * @param string $titular name of the user (for example Alonso Cotos)
     * @throws Exception
     */
    public function setTitular($titular='')
    {
        if(strlen(trim($titular)) > 0){
            $this->_setParameters['DS_MERCHANT_TITULAR'] = trim($titular);
        }
        else{
            throw new TpvException('Add name for the user');
        }

    }

    /**
     * Set Trade name Trade name will be reflected in the ticket trade (Optional)
     *
     * @param string $tradename trade name
     * @throws Exception
     */
    public function setTradeName($tradename='')
    {
        if(strlen(trim($tradename)) > 0){
            $this->_setParameters['DS_MERCHANT_MERCHANTNAME'] = trim($tradename);
        }
        else{
            throw new TpvException('Add name for Trade name');
        }
    }

    /**
     * Payment type
     *
     * @param string $method [T = Pago con Tarjeta + iupay , R = Pago por Transferencia, D = Domiciliacion, C = Sólo Tarjeta (mostrará sólo el formulario para datos de tarjeta)] por defecto es T
     * @throws Exception
     */
    public function setMethod($method='T')
    {
        if(strlen(trim($method)) > 0){
            $this->_setParameters['DS_MERCHANT_PAYMETHODS'] = trim($method);
        }
        else{
            throw new TpvException('Add pay method');
        }
    }

    /**
     * Card number
     *
     * @param $pan Tarjeta. Su longitud depende del tipo de tarjeta.
     * @throws TpvException
     */
    public function setPan($pan)
    {
        if (intval($pan) != 0){
            $this->_setParameters['DS_MERCHANT_PAN'] = $pan;
        }
        else{
            throw new TpvException('Pan not valid');
        }
    }

    /**
     * Expire date
     *
     * @param $expirydate . Caducidad de la tarjeta. Su formato es AAMM, siendo AA los dos últimos dígitos del año y MM los dos dígitos del mes.
     * @throws TpvException
     */
    public function setExpiryDate($expirydate)
    {
        if (strlen(trim($expirydate)) == 4){
            $this->_setParameters['DS_MERCHANT_EXPIRYDATE'] = $expirydate;
        }
        else{
            throw new TpvException('Expire date is not valid');
        }
    }

    /**
     * CVV2 card
     *
     * @param $cvv2 Código CVV2 de la tarjeta
     * @throws TpvException
     */
    public function setCVV2($cvv2)
    {
        if (intval($cvv2) != 0){
            $this->_setParameters['DS_MERCHANT_CVV2'] = $cvv2;
        }
        else{
            throw new TpvException('CVV2 is not valid');
        }
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
     * @param string $name Name submit
     * @param string $id Id submit
     * @param string $value Value submit
     * @param string $style Set Style
     */
    public function setAttributesSubmit($name = 'btn_submit', $id='btn_submit', $value='Send', $style='', $cssClass='')
    {
        $this->_setNameSubmit = $name;
        $this->_setIdSubmit = $id;
        $this->_setValueSubmit = $value;
        $this->_setStyleSubmit = $style;
        $this->_setClassSubmit = $cssClass;
    }

    /**
     * Execute redirection to TPV
     */
    public function executeRedirection()
    {
        echo $this->createForm();
        echo '<script>document.forms["'.$this->_setNameForm.'"].submit();</script>';
    }

    /**
     * Generate form html
     *
     * @return string
     */
    public function createForm()
    {
        $form='
            <form action="'.$this->_setEnviroment.'" method="post" id="'.$this->_setIdForm.'" name="'.$this->_setNameForm.'" >
                <input type="hidden" name="Ds_MerchantParameters" value="'.$this->generateMerchantParameters().'"/>
                <input type="hidden" name="Ds_Signature" value="'.$this->_setSignature.'"/>
                <input type="hidden" name="Ds_SignatureVersion" value="'.$this->_setVersion.'"/>
                <input type="submit" name="'.$this->_setNameSubmit.'" id="'.$this->_setIdSubmit.'" value="'.$this->_setValueSubmit.'" '.($this->_setStyleSubmit != '' ? ' style="' . $this->_setStyleSubmit . '"': '').' '.($this->_setClassSubmit != '' ? ' class="' . $this->_setClassSubmit . '"': '').'>
            </form>
        ';

        return $form;
    }

    /**
     * Check if properly made ​​the purchase.
     *
     * @param string $key Key
     * @param array $postData Data received by the bank
     * @return bool
     * @throws TpvException
     */
    public function check($key='', $postData)
    {
        if (isset($postData))
        {
            $version = $postData["Ds_SignatureVersion"];
            $parameters = $postData["Ds_MerchantParameters"];
            $signatureReceived = $postData["Ds_Signature"];


            $decodec = $this->decodeParameters($parameters);
            $signature = $this->generateMerchantSignatureNotification($key,$parameters);

            if ($signature === $signatureReceived){
                return 1;
            } else {
                return 0;
            }

        } else {
            throw new TpvException("Add data return of bank");
        }
    }


    /**
     *  Decode Ds_MerchantParameters, return array with the parameters
     * @param $parameters
     * @return array with parameters of bank
     */
    public function getMerchantParameters($parameters){
        $decodec = $this->decodeParameters($parameters);
        $decodec_array=$this->JsonToArray($decodec);
        return $decodec_array;
    }


    /**
     * Return array with all parameters assigned.
     * @return array
     */
    public function getParameters()
    {
        return $this->_setParameters;
    }

    /**
     * Return version
     * @return string
     */
    public function getVersion()
    {
        return $this->_setVersion;
    }

    /**
     * Return MerchantSignature
     * @return string
     */
    public function getMerchantSignature()
    {
        return $this->_setSignature;
    }

    // ******** UTILS ********

    /**
     * Convert Array to json
     * @param $data Array
     * @return string Json
     */
    private function arrayToJson($data)
    {
        return json_encode($data);
    }

    /**
     * Convert Json to array
     * @param $data
     * @return mixed
     */
    private function JsonToArray($data)
    {
        return json_decode($data, true);
    }

    /**
     * Generate sha256
     * @param $data
     * @param $key
     * @return string
     */
    private function hmac256($data, $key)
    {
        $sha256 = hash_hmac('sha256', $data, $key, true);
        return $sha256;
    }

    /**
     * Encrypt to 3DES
     * @param $data Data for encrypt
     * @param $key Key
     * @return string
     */
    private function encrypt_3DES($data, $key){
        $iv = "\0\0\0\0\0\0\0\0";
        $data_padded = $data;

        if (strlen($data_padded) % 8) {
            $data_padded = str_pad($data_padded,strlen($data_padded) + 8 - strlen($data_padded) % 8, "\0");
        }

        $ciphertext = openssl_encrypt($data_padded, "DES-EDE3-CBC", $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
        return $ciphertext;
    }

    private function decodeParameters($data){
        $decode = base64_decode(strtr($data, '-_', '+/'));
        return $decode;
    }

    //http://stackoverflow.com/a/9111049/444225
    private function priceToSQL($price)
    {
        $price = preg_replace('/[^0-9\.,]*/i', '', $price);
        $price = str_replace(',', '.', $price);
        if(substr($price, -3, 1) == '.')
        {
            $price = explode('.', $price);
            $last = array_pop($price);
            $price = join($price, '').'.'.$last;
        }
        else
        {
            $price = str_replace('.', '', $price);
        }
        return $price;
    }

    private function convertNumber($price)
    {
        $number=number_format(str_replace(',', '.', $price), 2, '.', '');
        return $number;

    }
    /******  Base64 Functions  *****
     * @param $input
     * @return string
     */
    private function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    /**
     * @param $data
     * @return string
     */
    private function encodeBase64($data)
    {
        $data = base64_encode($data);
        return $data;
    }

    /**
     * @param $input
     * @return string
     */
    private function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * @param $data
     * @return string
     */
    private function decodeBase64($data)
    {
        $data = base64_decode($data);
        return $data;
    }

    // ******** END UTILS ********

}
