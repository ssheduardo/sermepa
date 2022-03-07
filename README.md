# Redsys

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]
[![Run Tests](https://github.com/ssheduardo/sermepa/actions/workflows/ci.yml/badge.svg)][link-workflows]

---

[![Visual Studio Code](https://ubublog.com/wp-content/uploads/2019/05/vsc.png)](https://code.visualstudio.com/)
_This project is friendly supported by [Visual Studio Code](https://code.visualstudio.com/)!_

---

## Historia

Esta clase nace porque no encontraba una clase de pasarela de pagos (TPV) que se pueda integrar directamente en una web. Existen
muchas pero para varios CMS y no me servían, solo quería montar algo fácil que pueda usar. Los ejemplos que vienen en la documentación oficial eran muy simples así que decidi realizar esta clase y ahora lo comparto con todos.

Válido para Sermepa y Redsys.

## Introducción

La clase `sermepa` actualmente `Redsys` sirve para generar el formulario que se comunicará con la pasarela de pagos que usan muchos bancos, como Santander, Sabadell, Lacaixa, etc.

Es una versión que irá creciendo y actualizándose poco a poco y mejorándolo. Si lo usas en algún proyecto y te ayudo en algo no dudes en decírmelo

## Requerimientos mínimos

PHP 5 >= 5.3.0, PHP 7.1, 8.0

## Créditos

Clase creada por Eduardo Diaz, Madrid 2012
Twitter: @eduardo_dx


## Actualización

- Agregado namespace.
- Se actualiza para trabajar con sha256, que ha sido un requisito del banco.
- Se cambian todos los nombres de la clases a ingles.
- Se crean nuevos métodos.
- Para facilitar la integración usamos funciones ya creadas.
- Rest.

## Instalación

### Si usas composer tienes 2 opciones

1.- Por línea de comandos
```bash
composer require sermepa/sermepa
```
2.- Creas o agregas a tu archivo **composer.json** la siguiente dependencia:

```json
{
   "require": {
      "sermepa/sermepa": "^1.3.2"
   }
}
```

Luego ejecutas:

    composer update


### Si en caso contrario no usas composer, bastará con clonar el repositorio

```bash
git clone https://github.com/ssheduardo/sermepa.git
```

## ¿Cómo usar la clase?

Ejemplo:

```php
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
    $redsys->setMethod('C'); //Solo pago con tarjeta, no mostramos iupay
    $redsys->setNotification('http://localhost/noti.php'); //Url de notificacion
    $redsys->setUrlOk('http://localhost/ok.php'); //Url OK
    $redsys->setUrlKo('http://localhost/ko.php'); //Url KO
    $redsys->setVersion('HMAC_SHA256_V1');
    $redsys->setTradeName('Tienda S.L');
    $redsys->setTitular('Pedro Risco');
    $redsys->setProductDescription('Compras varias');
    $redsys->setEnvironment('test'); //Entorno test

    $signature = $redsys->generateMerchantSignature($key);
    $redsys->setMerchantSignature($signature);

    $form = $redsys->createForm();
} catch (\Sermepa\Tpv\TpvException $e) {
    echo $e->getMessage();
}
echo $form;
```

Con esto generamos el form para la comunicación con la pasarela de pagos.

### Nota
Con la integración del pago con referencia, ahora el importe **puede ser 0**. Según la documentación, si se quiere generar dicho identificador, se puede pasar el importe a 0 para obtener dicho valor, si en caso contrario no se utiliza el pago con referencia y se pasa el importe en 0, el banco nos mostrará un error.

## Enviar datos de la tarjeta

Si queremos enviar los datos de la tarjeta para que no nos lo solicite la pasarela de pagos, podemos hacerlo de la siguiente forma.

```php
try{
    $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

    $redsys = new Sermepa\Tpv\Tpv();
    $redsys->setAmount(rand(10,600));
    $redsys->setOrder(time());
    $redsys->setMerchantcode('999008881'); //Reemplazar por el código que proporciona el banco
    $redsys->setCurrency('978');
    $redsys->setTransactiontype('0');
    $redsys->setTerminal('1');
    $redsys->setMethod('C'); //Solo pago con tarjeta, no mostramos iupay
    $redsys->setNotification('http://localhost/noti.php'); //Url de notificacion
    $redsys->setUrlOk('http://localhost/ok.php'); //Url OK
    $redsys->setUrlKo('http://localhost/ko.php'); //Url KO
    $redsys->setVersion('HMAC_SHA256_V1');
    $redsys->setTradeName('Tienda S.L');
    $redsys->setTitular('Pedro Risco');

    $redsys->setPan('4548812049400004'); //Número de la tarjeta
    $redsys->setExpiryDate('2012'); //AAMM (año y mes)
    $redsys->setCVV2('123'); //CVV2 de la tarjeta

    $redsys->setEnvironment('test'); //Entorno test

    $signature = $redsys->generateMerchantSignature($key);
    $redsys->setMerchantSignature($signature);

    $form = $redsys->createForm();
} catch (\Sermepa\Tpv\TpvException $e) {
    echo $e->getMessage();
}
echo $form;
```

## Pago con referencia

Esta operativa nos permite guardar los datos de la tarjeta. SIS almacena la tarjeta y devuelve la referencia que deberá ser almacenada por el comercio.

Imaginemos que en el ejemplo anterior, queremos guardar los datos de la tarjeta, solo bastará con agregar el método `setIdentifier()`. Cuando se haga el llamado a la url de notificación, éste nos devolverá `Ds_Merchant_Identifier` y `Ds_ExpiryDate`.

```php
//Para una nueva referencia agregar este método al ejemplo anterior
$redsys->setIdentifier();

//En la url de notificación nos devolverá algo como esto
Array
(
    [Ds_Date] => 17%2F02%2F2022
    [Ds_Hour] => 23%3A25
    [Ds_SecurePayment] => 1
    [Ds_Card_Number] => 491801******4602
    [Ds_ExpiryDate] => 3212
    [Ds_Merchant_Identifier] => 2214a9c5ac0bd6e0fg476e6b3468ac4fa38a592c
    [Ds_Card_Country] => 724
    [Ds_Amount] => 0
    [Ds_Currency] => 978
    [Ds_Order] => 1645136683
    [Ds_MerchantCode] => 999008881
    [Ds_Terminal] => 001
    [Ds_Response] => 0000
    [Ds_MerchantData] =>
    [Ds_TransactionType] => 0
    [Ds_ConsumerLanguage] => 1
    [Ds_AuthorisationCode] => 005090
    [Ds_Card_Brand] => 1
    [Ds_Merchant_Cof_Txnid] => 2202172334011
    [Ds_ProcessedPayMethod] => 1
    [Ds_Control_1645136701458] => 1645136701458
)

```

Ahora bien, si queremos realizar otro cobro sin que nos pidan los datos de la tarjeta para ese mismo usuario, bastará con pasar el `Ds_Merchant_Identifier` anterior en el método `setIdentifier()`.

Cada banco tiene un sistema de seguridad a través de un código de SMS, tarjeta de coordenadas, etc. que se mostrará para completar la transacción.

```php
$redsys->setIdentifier(2214a9c5ac0bd6e0fg476e6b3468ac4fa38a592c);

//En la url de notificación nos devolverá algo como esto
Array
(
    [Ds_Date] => 17%2F02%2F2022
    [Ds_Hour] => 23%3A28
    [Ds_SecurePayment] => 1
    [Ds_Card_Number] => 491801******4602
    [Ds_Merchant_Identifier] => 2214a9c5ac0bd6e0fg476e6b3468ac4fa38a592c
    [Ds_Card_Country] => 724
    [Ds_Amount] => 12000
    [Ds_Currency] => 978
    [Ds_Order] => 1645136909
    [Ds_MerchantCode] => 999008881
    [Ds_Terminal] => 001
    [Ds_Response] => 0000
    [Ds_MerchantData] =>
    [Ds_TransactionType] => 0
    [Ds_ConsumerLanguage] => 1
    [Ds_AuthorisationCode] => 078737
    [Ds_Card_Brand] => 1
    [Ds_Merchant_Cof_Txnid] => 2202172334011
    [Ds_ProcessedPayMethod] => 1
    [Ds_Control_1645136925978] => 1645136925978
)
```

Si no queremos que nos muestre ninguna pantalla y directamente realice el pago debemos hacer uso del método `setMerchantDirectPayment()`:

```php
$redsys->setMerchantDirectPayment(true);
```
También podemos hacer los cobros recurrentes a traves de Rest.
```php
try{
    //Key de ejemplo
    $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

    $redsys = new Sermepa\Tpv\Tpv();
    $redsys->setAmount(rand(20,80));
    $redsys->setOrder(time());
    $redsys->setMerchantcode('999008881'); //Reemplazar por el código que proporciona el banco

    $redsys->setCurrency('978');
    $redsys->setTransactiontype('0');
    $redsys->setTerminal('1');
    $redsys->setIdentifier('2214a9c5ac0bd6e0fg476e6b3468ac4fa38a592c');
    $redsys->setVersion('HMAC_SHA256_V1');
    $redsys->setEnvironment('restTest'); //Rest entorno test
    $redsys->setMerchantCofIni('N');
    $redsys->setMerchantDirectPayment(true);

    $redsys->setMerchantCofTxnid(2202172334011);

    $signature = $redsys->generateMerchantSignature($key);
    $redsys->setMerchantSignature($signature);

    $response = json_decode($redsys->send(), true);

    $parameters = $redsys->getMerchantParameters($response['Ds_MerchantParameters']);
    $DsResponse = $parameters["Ds_Response"];
    $DsResponse += 0;
    if ($redsys->check($key, $response) && $DsResponse <= 99) {
        //Si es todo correcto ya podemos hacer lo que necesitamos, para este ejemplo solo mostramos los datos.
        print_r($parameters);
    } else {
        //acciones a realizar si ha sido erroneo
    }

} catch (\Sermepa\Tpv\TpvException $e) {
    echo $e->getMessage();
}

```

## Redirección automática

Podemos forzar la redirección sin pasar por el método `createForm()` (gracias a la colaboración de [jaumecornado](https://github.com/jaumecornado))

```php
$redsys->executeRedirection();
```

Este método llamaría a `createForm()` y lanzaría el submit por javascript.

## Comprobación de Pago

Podemos comprobar si se ha realizado el pago correctamente (gracias a la colaboración de [markitosgv](https://github.com/markitosgv)). Para ello necesitamos setear la clave del banco y pasar la variable `$_POST` que nos devuelve en la URL de notificación o de retorno. Tener en cuenta que debemos realizar esta comprobación en la url de notificación. Por ejemplo, en el fichero que es llamado por la URL de retorno:

```php
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
} catch (\Sermepa\Tpv\TpvException $e) {
    echo $e->getMessage();
}
```

### Nota

Por defecto se conecta por la pasarela de pruebas. Para cambiar a un entorno real, usar el método `setEnvironment('live')`, con esto ya estará activo.

```php
Los entornos que tenemos son:
 - test
 - live
 - restLive
 - restTest
```

## Métodos útiles

### Asignar parámetros
Este método recibe un array asociativo con los nuevos valores a asignar.

Ejemplo:
```php
$parameters = ['DS_MERCHANT_CHARGEEXPIRYDATE' => '2020', 'DS_MERCHANT_COF_INI' => 'S'];
$redsys->setParameters($parameters);
```
### Asignar nombre a id y name del formulario

```php
$redsys->setNameForm('nombre_formulario');
$redsys->setIdForm('id_formulario');
```

### Cambiar el idioma de la pasarela de pago

```php
//Esto mostraría la pasarela de pago en inglés
$redsys->setLanguage('002');
```

Códigos de idiomas disponibles:

- 001: Castellano
- 002: Inglés
- 003: Catalán
- 004: Francés
- 005: Alemán
- 006: Holandés
- 007: Italiano
- 008: Sueco
- 009: Portugués
- 010: Valenciano
- 011: Polaco
- 012: Gallego
- 013: Euskera

### Asignar nombre, id, value y style (css) al botón submit

```php
$redsys->setAttributesSubmit('btn_submit', 'btn_id', 'Enviar', 'font-size:14px; color:#ff00c1');
```

Si usáis redirección podéis ocultar el botón con `display:none`

### Generar formulario

```php
$redsys->createForm();
```

### Obtener un array con todos los datos asignados

```php
$redsys->getParameters();
```

Por ejemplo, esto nos devuelve:

    Array
    (
        [DS_MERCHANT_AMOUNT] => 1700
        [DS_MERCHANT_ORDER] => 160224230429
        [DS_MERCHANT_MERCHANTCODE] => XXXXXX
        [DS_MERCHANT_CURRENCY] => 978
        [DS_MERCHANT_TRANSACTIONTYPE] => 0
        [DS_MERCHANT_TERMINAL] => 1
        [DS_MERCHANT_PAYMETHODS] => C
        [DS_MERCHANT_MERCHANTURL] => http://demo.com/notificacion.php
        [DS_MERCHANT_URLOK] => http://demo.com/accept
        [DS_MERCHANT_URLKO] => http://demo.com/cancel
        [DS_MERCHANT_MERCHANTNAME] => Tu empresa
        [DS_MERCHANT_TITULAR] => Usuario
        [DS_MERCHANT_PRODUCTDESCRIPTION] => Tu descripción
    )

### Obtener un array de los datos devueltos por `Ds_MerchantParameters`

```php
$redsys->getMerchantParameters($_POST["Ds_MerchantParameters"]);
```

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

### Obtener Versión

```php
$redsys->getVersion()
```

Devuelve el valor asignado en `setVersion()`, por ejemplo: `HMAC_SHA256_V1`;

### Obtener MerchantSignature

```php
$redsys->getMerchantSignature()
```

Devuelve el valor asignado en `setMerchantSignature()`, por ejemplo: `Cia90trhTPGxtJDmK6WDhqXzU+98LbuKZKAKYHMjtMs=`

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Licencia

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sermepa/sermepa.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sermepa/sermepa.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sermepa/sermepa
[link-downloads]: https://packagist.org/packages/sermepa/sermepa
[link-author]: https://github.com/ssheduardo

 [link-workflows]: https://github.com/ssheduardo/sermepa/actions/workflows/ci.yml

## Donación

¿Te gustaría apoyarme?
¿Aprecias mi trabajo?
¿Lo usas en proyectos comerciales?

¡Siéntete libre de hacer una pequeña [donación](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ssh%2eeduardo%40gmail%2ecom&lc=ES&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted)! :wink:

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ssh%2eeduardo%40gmail%2ecom&lc=ES&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted)