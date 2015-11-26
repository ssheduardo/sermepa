# Redys

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Historia
--------
Esta clase nace porque no te encontraba una clase de pasarela de pagos (TPV) que se pueda integrar directamente en una web, existen
muchas pero para varios CMS y no me servian, solo quería montar algo fácil que pueda usar, los ejemplos que vienen en la documentación oficial era muy simple así que decidi realizar esta clase y ahora lo comparto con todos.

    Valido para Sermepa y Redsys.

Introducción
------------
La clase sermepa sirve para generar el formulario que se comunicará con la pasarela de pagos que usan muchos bancos como: Sabadell, Lacaixa, etc.

Es una versión que ira creciendo y actualizandose poco a poco y mejorandolo.
Si lo usas en algún proyecto y te ayudo en algo no dudas en decirmelo

Requerimientos mínimos
----------------------
PHP 5.3.0

Creditos
--------
    Clase creada por Eduardo Diaz, Madrid 2012
    Twitter: @eduardo_dx


Actualización
-------------
    - Agregado namespace.
    - Se actualiza para trabajar con sha256, que ha sido un requisito del banco.
    - Se cambian todos los nombres de la clases a Ingles.
    - Se crean nuevos métodos.
    - Para facilitar la integración usamos funciones ya creadas.

Instalación
-----------
**Si usas composer tienes 2 opciones**

1.- Por linea de comandos
```bash
    composer require sermepa/sermepa
```
2.- Creas o agregas a tu archivo **composer.json** la siguiente dependencia:

```json
    {
       "require": {
          "sermepa/sermepa": "^1.1"
       }
    }
```

Luego ejecutas:

    composer update


**Si en caso contrario no usas composer, bastará con clonar el repositorio**
```
git clone https://github.com/ssheduardo/sermepa.git
```


Como usar la clase
------------------
**Ejemplo**

    //Si usas composer
    //include_once('vendor/autoload.php');

    //Si clonaste la clase
    //include_once('sermepa/src/Sermepa/Tpv/Tpv.php');

    try{
        //Key de ejemplo
        $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

        $redsys = new Sermepa\Tpv\Tpv();
        $redsys->setAmount(rand(10,600));
        $redsys->setOrder(time());
        $redsys->setMerchantcode('999008881'); //Reemplazar por el código que proporciona el banco
        $redsys->setCurrency('978');
        $redsys->setTransactiontype('0');
        $redsys->setTerminal('1');
        $redsys->setNotification('http://localhost/noti.php'); //Url de notificacion
        $redsys->setUrlOk('http://localhost/ok.php'); //Url OK
        $redsys->setUrlKo('http://localhost/ko.php'); //Url KO
        $redsys->setVersion('HMAC_SHA256_V1');
        $redsys->setTradeName('Tienda S.L');
        $redsys->setTitular('Pedro Risco');
        $redsys->setProductDescription('Compras varias');
        $redsys->setEnviroment('test'); //Entorno test

        $signature = $redsys->generateMerchantSignature($key);
        $redsys->setMerchantSignature($signature);

        $form = $redsys->createForm();
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    echo $form;

Con esto generamos el form para la comunicación con la pasarela de pagos.


**Redirección automática**

    //Gracias por a la colaboración de jaumecornado (github)
    Podemos forzar la redirección sin pasar por el método createForm()
    $redsys->executeRedirection();

    [Esto método llamaría a createForm y lanzaría el submit por javacript]

**Comprobación de Pago**

    //Gracias por a la colaboración de markitosgv (github)
    Podemos comprobar si se ha realizado el pago correctamente. Para ello necesitamos setear la clave del banco y pasar la variable $_POST que nos devuelve en la URL de notificación o de retorno. Por ejemplo, en el fichero que es llamado por la URL de retorno:

    try{
        $redsys = new Sermepa\Tpv\Tpv();
        $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

        $parameters = $redsys->getMerchantParameters($_POST["Ds_MerchantParameters"]);
        $DsResponse = $parameters["Ds_Response"];
        $DsResponse += 0;
        if ($redsys->check($key, $_POST) && $DsResponse <= 99) {
            //acciones a realizar si es correcto, por ejemplo validar una reserva, mandar un mail de OK, guardar en bbdd o contactar con mensajería para preparar un pedido
        } else {
            //acciones a realizar si ha sido erroneo
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

>Nota:
    Por defecto se conecta por la pasarela de pruebas para cambiar a un entorno real usar el método: setEnviroment('live'), con esto ya estará activo.

Métodos útiles
-----------

**Asignar nombre a id y name del formulario**

        $redsys->setNameForm('nombre_formulario');
        $redsys->setIdForm('id_formulario');

**Asignar nombre, id, value y style (css) al botón submit, si usáis redirección podéis ocultar el botón con display:none**

        $redsys->setAttributesSubmit('btn_submit','btn_id','Enviar','font-size:14px; color:#ff00c1');

**Generar formulario**

        $redsys->createForm();

**Obtener un array de los datos devueltos por Ds_MerchantParameters**

        $redsys->getMerchantParameters($_POST["Ds_MerchantParameters"]

        Esto nos devuelve:
            [Ds_Date] => 12/11/2015
            [Ds_Hour] => 14:04
            [Ds_SecurePayment] => 1
            [Ds_Card_Number] => 454881******0004
            [Ds_Card_Country] => 724
            [Ds_Amount] => 7300
            [Ds_Currency] => 978
            [Ds_Order] => 1447333990
            [Ds_MerchantCode] => 999008881
            [Ds_Terminal] => 001
            [Ds_Response] => 0000
            [Ds_MerchantData] =>
            [Ds_TransactionType] => 0
            [Ds_ConsumerLanguage] => 1
            [Ds_AuthorisationCode] => 906611



## Licencia

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sermepa/sermepa.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sermepa/sermepa.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sermepa/sermepa
[link-downloads]: https://packagist.org/packages/sermepa/sermepa
[link-author]: https://github.com/ssheduardo
