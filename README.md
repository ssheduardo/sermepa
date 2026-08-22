# Redsys - Biblioteca PHP para Pasarela de Pagos

[![Latest Version on Packagist][ico-version]][link-packagist]
[![PHP Version][ico-php]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]
[![Run Tests](https://github.com/ssheduardo/sermepa/actions/workflows/ci.yml/badge.svg)][link-workflows]

Biblioteca PHP para integrar la pasarela de pagos Redsys/Sermepa (Santander, Sabadell, LaCaixa, BBVA, etc.)

## Requisitos

- PHP 7.1.3+ a 8.5
- ext-curl
- ext-openssl
- ext-json

## Instalación

```bash
composer require sermepa/sermepa
```

## Inicio Rápido

```php
use Sermepa\Tpv\Tpv;

$redsys = new Tpv();
$redsys->setAmount(2500)           // 25.00€
    ->setOrder('1234AB')
    ->setMerchantcode('999008881')
    ->setCurrency('978')           // Euros
    ->setTransactiontype('0')       // Autorización
    ->setTerminal('1')
    ->setMethod('C')                // Solo tarjeta
    ->setNotification('https://tusitio.com/notificacion')
    ->setUrlOk('https://tusitio.com/ok')
    ->setUrlKo('https://tusitio.com/ko')
    ->setEnvironment('test');       // Entorno de pruebas

$signature = $redsys->generateMerchantSignature('TU_CLAVE_SECRETA');
$redsys->setMerchantSignature($signature);

echo $redsys->createForm();
```

## Entornos Disponibles

| Entorno | Descripción |
|---------|-------------|
| `test` | Pruebas (SIS Sandbox) |
| `live` | Producción |
| `restTest` | API REST Pruebas |
| `restLive` | API REST Producción |
| `insiteSandbox` | InSite Pruebas (JS + REST) |
| `insiteLive` | InSite Producción (JS + REST) |
| `insiteRestSandbox` | InSite REST Pruebas (solo pago) |
| `insiteRestLive` | InSite REST Producción (solo pago) |

## Métodos de Pago

| Código | Descripción |
|--------|-------------|
| `C` o `T` | Tarjeta |
| `R` | Transferencia |
| `D` | Domiciliación |
| `z` | Bizum |
| `p` | PayPal |
| `N` | Masterpass |
| `xpay` | GooglePay / ApplePay |

## Tipos de Transacción

| Código | Descripción | Canal |
|--------|-------------|-------|
| `0` | Autorización | Redirección / REST / SOAP |
| `1` | Preautorización | Redirección / REST / SOAP |
| `2` | Confirmación de preautorización | Redirección / REST / SOAP |
| `3` | Devolución | Redirección / REST / SOAP |
| `7` | Preautorización separada (autenticación) | Redirección / REST / SOAP |
| `8` | Confirmación de autenticación | Redirección / REST / SOAP |
| `9` | Anulación de preautorización o autorización | Redirección / REST / SOAP |
| `11` | Preautorización de reemplazo | Redirección / REST / SOAP |
| `15` | PayGold (solicitud de pago) | REST / SOAP |
| `17` | Autenticación PUCE | REST / SOAP |
| `34` | Devolución sin original | Redirección / REST / SOAP |
| `37` | Premio de apuestas / abono | REST / SOAP |
| `38` | PayGold - autorización del titular | — |
| `44` | Anulación de referencia (borrar token) | REST |
| `45` | Anulación de pago | Redirección / REST / SOAP |
| `46` | Anulación de devolución | Redirección / REST / SOAP |
| `47` | Anulación de confirmación separada | Redirección / REST / SOAP |
| `48` | Confirmación parcial | REST / SOAP |
| `51` | Modificación de caducidad del enlace (PayGold) | Redirección / REST / SOAP |

## Códigos de Respuesta

El banco devuelve un código en `Ds_Response`. Los principales:

| Código | Significado |
|--------|-------------|
| `0000` a `0099` | Pago aprobado |
| `0100` a `0199` | Operatoria OK, verificación CVV obligatoria |
| `0200` | Error de formato |
| `0201` | Error de firma |
| `0204` | Error de datos |
| `0209` | Error de tajeta |
| `0214` | Fecha de caducidad errónea |
| `0215` | Error en importe mínimo (no usado) |
| `0290` | Tarjeta no autorizada |
| `0401` | Error en posición de tarjeta |
| `0404` | Error de configuración de comercio |
| `0501` | Operaciones pendientes |
| `0904` | Comercio no operativo |
| `0912` | Emisor no disponible |
| `9912` | Emisor no disponible |
| `9913` | Error en comunicación |
| `9914` | Fallo al conectar con CA |
| `9919` | Error de cryptograma |
| `9929` | Error de deslinde |
| `9932` | Error de bin |
| `9933` | Error de BS. Cambio de dinámico a estático |
| `9934` | Error de BS. Cambio de estático a dinámico |
| `9951` | Operación de ingreso OK |
| `9952` | Operación de ingreso NO OK |
| `9953` | Devolución OK |
| `9954` | Devolución NO OK |
| `9955` | Anulación OK |
| `9956` | Anulación NO OK |
| `9957` | Ajuste OK |
| `9958` | Ajuste NO OK |
| `9961` | Error en cierre batch |
| `9962` | Error en apertura batch |
| `9963` | Error de operativa |
| `9992` | Petición cancelada |
| `9993` | Operatoria abandonada por el usuario |
| `9995` | Operatoria abandonada - tiempo excedido |
| `9996` | Error de conexión |
| `9997` | Error de timeout |
| `9998` | Error de validación |
| `9999` | Error general |

> **Nota:** Para pagos exitosos, el código debe estar entre `0000` y `0099`. Convertir a entero para comparar: `$DsResponse = (int) $parameters['Ds_Response'];`

## Validar Respuesta del Banco

En tu URL de notificación (`setNotification`), debes validar la respuesta del banco:

```php
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

try {
    $redsys = new Tpv();
    $key = 'TU_CLAVE_SECRETA';

    // Decodificar parámetros recibidos
    $parameters = $redsys->getMerchantParameters($_POST['Ds_MerchantParameters']);
    $DsResponse = (int) $parameters['Ds_Response'];

    // Validar firma y respuesta
    if ($redsys->check($key, $_POST) && $DsResponse <= 99) {
        // Pago correcto -Ds_Response = 0000 a 0099
        // Aquí: actualizar pedido, enviar email, etc.
    } else {
        // Pago fallido
    }
} catch (TpvException $e) {
    error_log('Error TPV: ' . $e->getMessage());
}
```

## Pago con Tarjeta Guardada (Token)

Guardar la tarjeta del cliente para pagos futuros:

```php
// 1. Crear referencia (primer pago)
$redsys->setIdentifier();  // Sin parámetros - indica "REQUIRED"

// Respuesta del banco contendrá:
// $parameters['Ds_Merchant_Identifier']
// $parameters['Ds_ExpiryDate']
```

```php
// 2. Usar referencia (pagos recurrentes)
$redsys->setIdentifier('IDENTIFICADOR_GUARDADO');
$redsys->setMerchantDirectPayment(true);  // Pago directo sin autenticación 3D Secure
```

### Borrar una referencia (token)

Para eliminar una referencia almacenada en Redsys, usa el tipo de transacción `44`:

```php
use Redsys\Merchant\MerchantTransactionTypes;

$redsys = new Tpv();
$redsys->setAmount(0)
    ->setOrder('1234AB')
    ->setMerchantcode('999008881')
    ->setCurrency('978')
    ->setTransactiontype(MerchantTransactionTypes::ANULACION_DE_REFERENCIA)  // 44
    ->setTerminal('1')
    ->setIdentifier('IDENTIFICADOR_A_BORRAR')  // Referencia que se quiere eliminar
    ->setEnvironment('restTest');

$signature = $redsys->generateMerchantSignature('TU_CLAVE_SECRETA');
$redsys->setMerchantSignature($signature);

$response = json_decode($redsys->send(), true);
```

## Enviar Datos de Tarjeta Directamente

Puedes enviar los datos de la tarjeta para que el usuario no tenga que introducirlos en la pasarela:

```php
$redsys->setPan('4548812049400004');     // Número de tarjeta
$redsys->setExpiryDate('1228');          // Caducidad (AAMM)
$redsys->setCVV2('123');                 // CVV2
```

> **Nota:** Esta opción requiere que tu comercio tenga autorización del banco para enviar datos de tarjeta directamente.

## API REST (Cobros sin formulario)

Para cobros directos sin redirección del usuario:

```php
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

try {
    $key = 'TU_CLAVE_SECRETA';

    $redsys = new Tpv();
    $redsys->setAmount(2500)
        ->setOrder('1234AB')
        ->setMerchantcode('999008881')
        ->setCurrency('978')
        ->setTransactiontype('0')
        ->setTerminal('1')
        ->setIdentifier('IDENTIFICADOR_GUARDADO')
        ->setMerchantDirectPayment(true)
        ->setVersion('HMAC_SHA256_V1')
        ->setEnvironment('restTest')
        ->setMerchantCofIni('N');

    $signature = $redsys->generateMerchantSignature($key);
    $redsys->setMerchantSignature($signature);

    $response = json_decode($redsys->send(), true);

    // Verificar error en respuesta
    if (isset($response['errorCode'])) {
        throw new Exception("Error: " . $response['errorCode']);
    }

    // Decodificar respuesta
    $parameters = $redsys->getMerchantParameters($response['Ds_MerchantParameters']);
    $DsResponse = (int) $parameters['Ds_Response'];

    if ($redsys->check($key, $response) && $DsResponse <= 99) {
        // Cobro correcto
    }
} catch (TpvException $e) {
    echo 'Error TPV: ' . $e->getMessage();
}
```

## InSite (Pago Embebido)

InSite permite incrustar el formulario de pago directamente en tu página web mediante un **iframe**, sin redirigir al usuario a la pasarela de Redsys. Los datos de tarjeta nunca pasan por tu servidor (cumplimiento PCI DSS).

> **Nota:** Tu dominio debe estar registrado en Redsys para usar InSite. Configura los dominios permitidos en el Portal de Administración del TPV Virtual. Contacta con tu banco o soporte de Redsys.

### Flujo de Integración

1. **Generar formulario InSite** - Renderiza el iframe en tu página
2. **Usuario completa pago** - Introduce datos en el iframe de Redsys
3. **Obtener ID de operación** - Redsys retorna un `idOper` (válido por 30 minutos)
4. **Ejecutar pago** - Envía el `idOper` mediante REST API

### Paso 1: Generar Formulario InSite (Modo Unificado)

El modo unificado genera un iframe completo con todos los campos de pago:

```php
use Sermepa\Tpv\Tpv;
use Redsys\Merchant\MerchantInsiteLanguage;

$redsys = new Tpv();
$redsys->setEnvironment('insiteSandbox')  // o 'insiteLive' para producción
    ->setOrder('1234AB')
    ->setMerchantcode('999008881')        // Tu código de comercio (FUC)
    ->setTerminal('1');

// Generar HTML del formulario InSite
$htmlForm = $redsys->createInSiteForm(
    'card-form',              // ID del contenedor
    'background: #007bff;',   // Estilo del botón
    'color: white;',          // Estilo del cuerpo
    'padding: 10px;',         // Estilo de la caja de datos
    'font-size: 14px;',       // Estilo de los inputs
    'Pagar',                  // Texto del botón (HTML encoded: 'Bot&#243;n' para Botón)
    MerchantInsiteLanguage::ISO_ES, // Idioma: 'ES', '1', etc.
    true,                     // Mostrar logo de entidad
    false,                    // Estilo reducido
    'inline'                  // Estilo InSite: 'inline' o 'twoRows'
);

echo $htmlForm;
```

### Modo JSON (Recomendado)

Para mayor flexibilidad, usa el método JSON:

```php
$htmlForm = $redsys->createInSiteFormJSON([
    'id' => 'card-form',
    'fuc' => '999008881',
    'terminal' => '1',
    'order' => '1234AB',
    'styleButton' => 'background: #007bff; color: white;',
    'styleBody' => 'font-family: Arial;',
    'styleBox' => 'padding: 10px;',
    'buttonValue' => 'Pagar ahora',
    'idiomaInsite' => 'ES',
    'mostrarLogoInsite' => true,
    'estiloReducidoInsite' => false,
    'estiloInsite' => 'inline'  // o 'twoRows'
]);
```

### Parámetros del Formulario

| Parámetro | Obligatorio | Descripción |
|-----------|-------------|-------------|
| `id` / `$containerId` | Sí | ID del contenedor div |
| `fuc` / merchantCode | Sí | Código de comercio (FUC) |
| `terminal` | Sí | Número de terminal |
| `order` | Sí | Número de pedido (4-12 caracteres) |
| `styleButton` | No | CSS para el botón de pago |
| `styleBody` | No | CSS para el cuerpo del formulario |
| `styleBox` | No | CSS para la caja de datos |
| `styleBoxText` | No | CSS para el texto de los inputs |
| `buttonValue` | No | Texto del botón (HTML encoded) |
| `idiomaInsite` | No | Código de idioma (ver tabla) |
| `mostrarLogoInsite` | No | Mostrar logo de entidad (default: true) |
| `estiloReducidoInsite` | No | Usar estilo reducido (default: false) |
| `estiloInsite` | No | 'inline' o 'twoRows' (default: 'inline') |

### Catálogo de Idiomas InSite

| Idioma | Código SIS | ISO 639-1 |
|--------|------------|-----------|
| Español | 1 | ES |
| Inglés | 2 | EN |
| Catalán | 3 | CA |
| Francés | 4 | FR |
| Alemán | 5 | DE |
| Italiano | 7 | IT |
| Portugués | 9 | PT |
| ... | ... | ... |

Usa las constantes de `MerchantInsiteLanguage`:

```php
use Redsys\Merchant\MerchantInsiteLanguage;

$redsys->createInSiteForm(..., MerchantInsiteLanguage::SPANISH, ...);
// o
$redsys->createInSiteForm(..., MerchantInsiteLanguage::ISO_ES, ...);
```

### Paso 2: Recibir ID de Operación

El formulario incluye automáticamente un listener que almacena el `idOper` en un campo hidden:

```html
<input type="hidden" id="token" name="token" value="">
<input type="hidden" id="errorCode" name="errorCode" value="">
```

Puedes personalizar la validación:

```javascript
function merchantValidation() {
    // Tu validación personalizada
    return true;  // true para continuar, false para cancelar
}

window.addEventListener("message", function receiveMessage(event) {
    storeIdOper(event, "token", "errorCode", merchantValidation);
});
```

### Códigos de Error InSite

| Código | Descripción |
|--------|-------------|
| msg1 | Ha de rellenar los datos de la tarjeta |
| msg2 | La tarjeta es obligatoria |
| msg3 | La tarjeta ha de ser numérica |
| msg15 | La longitud de la tarjeta no es correcta |
| msg16 | Debe introducir un número de tarjeta válido |
| msg17 | Validación incorrecta por parte del comercio |
| msg18 | Error de inicialización de dominio |

Usa `MerchantInsiteError` para obtener descripciones:

```php
use Redsys\Merchant\MerchantInsiteError;

$errorDescription = MerchantInsiteError::getDescription('msg1');
```

### Paso 3: Ejecutar Pago con ID de Operación

```php
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

try {
    $key = 'TU_CLAVE_SECRETA';
    $idOper = $_POST['token'];    // ID recibido del iframe
    $order = '1234AB';             // Mismo pedido usado en el formulario

    $redsys = new Tpv();
    $redsys->setEnvironment('insiteRestLive')  // o 'insiteRestSandbox'
        ->setAmount(2500)
        ->setOrder($order)          // DEBE ser el mismo que en createInSiteForm
        ->setMerchantcode('999008881')
        ->setCurrency('978')
        ->setTransactiontype('0')
        ->setTerminal('1');

    // Ejecutar pago con el ID de operación
    $response = json_decode($redsys->sendInSite($idOper, $key), true);

    // Decodificar respuesta
    $parameters = $redsys->getMerchantParameters($response['Ds_MerchantParameters']);
    $DsResponse = (int) $parameters['Ds_Response'];

    if ($DsResponse >= 0 && $DsResponse <= 99) {
        // Pago aprobado
    } else {
        // Pago denegado
    }

} catch (TpvException $e) {
    echo 'Error TPV: ' . $e->getMessage();
}
```

### Métodos InSite

| Método | Descripción |
|--------|-------------|
| `setInSite(bool)` | Habilitar/deshabilitar modo InSite |
| `getInSiteMode()` | Obtener estado del modo InSite |
| `getInSiteJsUrl()` | Obtener URL del JavaScript de InSite |
| `createInSiteForm(string $containerId, string $buttonStyle, string $bodyStyle)` | Generar HTML del formulario embebido |
| `sendInSite(string $idOper, string $key)` | Ejecutar pago con ID de operación |

### Personalización del Formulario

```php
// Generar formulario con estilos personalizados
$html = $redsys->createInSiteForm(
    'card-form',                                    // ID del contenedor
    'background-color: #28a745; color: white; padding: 15px; border: none; border-radius: 5px;',  // Estilo botón
    'font-family: Arial, sans-serif;'               // Estilo cuerpo
);
```

## Redirección Automática

Para redirección automática sin mostrar el botón:

```php
$redsys->executeRedirection();
// Opcional: obtener HTML
$html = $redsys->executeRedirection(true);
```

## Integración con JavaScript de Redsys

La biblioteca incluye un método estático para obtener la ruta del JavaScript de Redsys:

```php
use Sermepa\Tpv\Tpv;

// Obtener URL del script
$jsUrl = Tpv::getJsPath('test', '3');  // Entorno test, versión 3
// https://sis-t.redsys.es:25443/sis/NC/sandbox/redsysV3.js
```

| Versión | Descripción |
|---------|-------------|
| `2` | Redsys Classic |
| `3` | Redsys API (soporte NFC, Apple Pay, Google Pay) |

## Constantes Disponibles

Usa las constantes predefinidas para evitar errores de transcripción:

```php
use Redsys\Merchant\MerchantCurrencies;
use Redsys\Merchant\MerchantTransactionTypes;
use Redsys\Merchant\MerchantConsumerLanguages;
use Redsys\Merchant\MerchantPaymethods;

// Monedas
$redsys->setCurrency(MerchantCurrencies::EUR);      // 978
$redsys->setCurrency(MerchantCurrencies::USD);      // 840
$redsys->setCurrency(MerchantCurrencies::GBP);     // 826

// Tipos de transacción
$redsys->setTransactiontype(MerchantTransactionTypes::AUTHORIZATION);  // 0
$redsys->setTransactiontype(MerchantTransactionTypes::PREAUTHORIZATION);  // 1

// Idiomas
$redsys->setLanguage(MerchantConsumerLanguages::SPANISH);   // 001
$redsys->setLanguage(MerchantConsumerLanguages::ENGLISH);   // 002
$redsys->setLanguage(MerchantConsumerLanguages::CATALAN);    // 003

// Métodos de pago
$redsys->setMethod(MerchantPaymethods::CARD);    // C
$redsys->setMethod(MerchantPaymethods::BIZUM);   // z
```

### Códigos de Moneda

Los códigos ISO 4217. Los más comunes:

- `978` - Euro (EUR)
- `840` - Dólar estadounidense (USD)
- `826` - Libra esterlina (GBP)
- `392` - Yen japonés (JPY)

### Códigos de Idioma

| Código | Idioma |
|--------|--------|
| 001 | Castellano |
| 002 | Inglés |
| 003 | Catalán |
| 004 | Francés |
| 005 | Alemán |
| 006 | Holandés |
| 007 | Italiano |
| 008 | Sueco |
| 009 | Portugués |
| 010 | Valenciano |
| 011 | Polaco |
| 012 | Gallego |
| 013 | Euskera |

## API Reference

### Métodos de Configuración

| Método | Descripción | Requerido |
|--------|-------------|-----------|
| `setAmount(float)` | Importe (se convierte a céntimos) | Sí |
| `setOrder(string)` | Número de pedido (4-12 caracteres, primeros 4 numéricos) | Sí |
| `setMerchantcode(string)` | Código de comercio (FUC) | Sí |
| `setCurrency(string)` | Código de moneda ISO | Sí |
| `setTransactiontype(string)` | Tipo de transacción | Sí |
| `setTerminal(string)` | Número de terminal | Sí |
| `setMethod(string)` | Método de pago | No |
| `setNotification(string)` | URL de notificación (callback) | Recomendado |
| `setUrlOk(string)` | URL si pago exitoso | Recomendado |
| `setUrlKo(string)` | URL si pago fallido | Recomendado |
| `setEnvironment(string)` | Entorno de conexión | No |
| `setVersion(string)` | Versión de firma | No |
| `setTradeName(string)` | Nombre del comercio | No |
| `setTitular(string)` | Titular del pago | No |
| `setProductDescription(string)` | Descripción del producto | No |

### Métodos de Firma y Envío

| Método | Descripción |
|--------|-------------|
| `generateMerchantSignature(string $key)` | Genera firma HMAC-SHA256 |
| `setMerchantSignature(string)` | Asigna la firma calculada |
| `createForm()` | Genera formulario HTML |
| `send()` | Envía petición REST (devuelve JSON) |
| `executeRedirection()` | Redirección automática con JavaScript |

### Métodos de Validación

| Método | Descripción |
|--------|-------------|
| `check(string $key, array $postData)` | Valida firma de respuesta del banco |
| `getMerchantParameters(string)` | Decodifica `Ds_MerchantParameters` |

### Métodos InSite

| Método | Descripción |
|--------|-------------|
| `setInSite(bool)` | Habilitar modo InSite |
| `getInSiteMode()` | Obtener estado del modo InSite |
| `getInSiteJsUrl()` | Obtener URL del JavaScript de InSite |
| `createInSiteForm(...)` | Genera formulario embebido (modo unificado) |
| `createInSiteFormJSON(array)` | Genera formulario embebido (modo JSON) |
| `sendInSite(string $idOper, string $key)` | Ejecuta pago con ID de operación |

#### Parámetros de createInSiteForm()

| Parámetro | Tipo | Obligatorio | Descripción |
|-----------|------|-------------|-------------|
| `$containerId` | string | No | ID del contenedor div (default: 'card-form') |
| `$buttonStyle` | string | No | CSS para el botón de pago |
| `$bodyStyle` | string | No | CSS para el cuerpo del formulario |
| `$boxStyle` | string | No | CSS para la caja de datos |
| `$inputStyle` | string | No | CSS para los inputs |
| `$buttonText` | string | No | Texto del botón (HTML encoded) |
| `$language` | string | No | Código de idioma (default: 'ES') |
| `$showLogo` | bool | No | Mostrar logo de entidad (default: true) |
| `$reducedStyle` | bool | No | Usar estilo reducido (default: false) |
| `$insiteStyle` | string | No | 'inline' o 'twoRows' (default: 'inline') |

### Métodos Auxiliares

| Método | Descripción |
|--------|-------------|
| `setNameForm(string)` | Nombre del formulario |
| `setIdForm(string)` | ID del formulario |
| `setAttributesSubmit(...)` | Personalizar botón submit |
| `setLanguage(string)` | Idioma de la pasarela |
| `setParameters(array)` | Parámetros adicionales |
| `setIdentifier(string)` | Referencia de tarjeta guardada |
| `setMerchantDirectPayment(bool)` | Pago directo sin autenticación |
| `setPan(string)` | Número de tarjeta |
| `setExpiryDate(string)` | Caducidad (AAMM) |
| `setCVV2(string)` | Código CVV2 |
| `setMerchantData(string)` | Datos adicionales del comercio |
| `getOrder()` | Obtener número de pedido |
| `getParameters()` | Obtener todos los parámetros |
| `getVersion()` | Obtener versión de firma |
| `getMerchantSignature()` | Obtener firma actual |
| `getEnvironment()` | Obtener URL del entorno |
| `getJsPath(string, string)` | Obtener ruta JS para integración moderna |
| `createOrderNumber(int)` | Generar número de pedido válido |

## Parámetros Avanzados

### Pagos Recurrentes

```php
$redsys->setMerchantCofIni('S');           // Inicio de COF
$redsys->setMerchantCofType('R');          // Tipo: R=Recurrente, I=Cuotas
$redsys->setMerchantCofTxnid('123456789'); // ID de transacción
$redsys->setSumtotal(50000);               // Importe total
$redsys->setChargeExpiryDate('2025-12-31'); // Fecha expiración
$redsys->setDateFrecuency(30);             // Frecuencia en días
```

### Excepción SCA (Strong Customer Authentication)

Algunos bancos requieren parámetros adicionales:

```php
$parameters = ['DS_MERCHANT_EXCEP_SCA' => 'MIT'];
$redsys->setParameters($parameters);
```

## Ejemplos Completos

### Ejemplo Completo: Pago Simple

```php
<?php
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

try {
    $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

    $redsys = new Tpv();
    $redsys->setAmount(25.50)
        ->setOrder(date('YmdHis'))  // 20240215120000
        ->setMerchantcode('999008881')
        ->setCurrency('978')
        ->setTransactiontype('0')
        ->setTerminal('1')
        ->setMethod('C')
        ->setNotification('https://tusitio.com/notificacion')
        ->setUrlOk('https://tusitio.com/ok')
        ->setUrlKo('https://tusitio.com/ko')
        ->setVersion('HMAC_SHA256_V1')
        ->setTradeName('Mi Tienda')
        ->setTitular('Cliente Ejemplo')
        ->setProductDescription('Compra en Mi Tienda')
        ->setEnvironment('test');

    $signature = $redsys->generateMerchantSignature($key);
    $redsys->setMerchantSignature($signature);

    echo $redsys->createForm();

} catch (TpvException $e) {
    echo 'Error: ' . $e->getMessage();
}
```

### Ejemplo Completo: Notificación (Callback)

```php
<?php
use Sermepa\Tpv\Tpv;
use Sermepa\Tpv\TpvException;

try {
    $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

    $redsys = new Tpv();

    // Decodificar parámetros
    $parameters = $redsys->getMerchantParameters($_POST['Ds_MerchantParameters']);

    // Obtener código de respuesta
    $DsResponse = (int) $parameters['Ds_Response'];
    $DsOrder = $parameters['Ds_Order'];

    // Validar firma y respuesta
    if ($redsys->check($key, $_POST)) {
        if ($DsResponse >= 0 && $DsResponse <= 99) {
            // Pago aprobado
            // Aquí: actualizar pedido en BDD, enviar confirmación, etc.
            error_log("Pago exitoso - Pedido: $DsOrder, Respuesta: $DsResponse");
        } else {
            // Pago denegado
            error_log("Pago denegado - Pedido: $DsOrder, Respuesta: $DsResponse");
        }
    } else {
        // Firma inválida - posible fraude
        error_log("Firma inválida - Pedido: $DsOrder");
    }

} catch (TpvException $e) {
    error_log('Error TPV: ' . $e->getMessage());
    http_response_code(500);
}
```

## Changelog

Ver [CHANGELOG.md](CHANGELOG.md) para más detalles.

## Troubleshooting

| Problema | Solución |
|----------|----------|
| **Error SIS0042 / Error de firma** | Verifica que la clave secreta (SHA-256) sea la correcta para el entorno (test vs live). |
| **Error SIS0019 / Número de pedido repetido** | Redsys no permite reutilizar un `Ds_Order` en las siguientes 24h. Genera uno único por transacción. |
| **Error SIS0078 / Terminal no habilitado** | Contacta con tu banco para activar el terminal en el entorno que usas (test o live). |
| **Error SIS0051 / Comercio no operativo** | El comercio no está activo en Redsys. Revisa la configuración en el Portal de Administración. |
| **Error SIS0218 / Operación no permitida** | El tipo de transacción no está habilitado para tu comercio. Solicita la activación al banco. |
| **El formulario no redirige** | Asegúrate de llamar a `createForm()` después de `setMerchantSignature()`. |
| **Notificación (callback) no llega** | Verifica que la URL de notificación sea pública, use HTTPS en producción y esté registrada en Redsys. |

## Licencia

MIT - Ver [LICENSE.md](LICENSE.md)

---

## Contribuidores

Gracias a todos los que han mejorado esta biblioteca:

- [Eduardo D](mailto:ssh.eduardo@gmail.com) — Autor original y mantenedor
- [jaumecornado](https://github.com/jaumecornado) — Redirección automática
- [markitosgv](https://github.com/markitosgv) — Validación de respuesta
- [HecFranco](https://github.com/HecFranco) — Fix TpvException en `send()` (PR #110)
- [alphp](https://github.com/alphp) — Tipo de transacción `ANULACION_DE_REFERENCIA` (PR #105)
- ... y [todos los contribuidores](https://github.com/ssheduardo/sermepa/graphs/contributors)

## Donación

¿Te gustaría apoyar este proyecto? ¡Gracias por tu aprecio!

[![Donar con PayPal](https://www.paypalobjects.com/es_ES/ES/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ssh%2eeduardo%40gmail%2ecom&lc=ES&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted)

## Support

¿Necesitas ayuda? [Abre un issue](https://github.com/ssheduardo/sermepa/issues)

[ico-version]: https://img.shields.io/packagist/v/sermepa/sermepa.svg?style=flat-square
[ico-php]: https://img.shields.io/badge/PHP-7.1%20to%208.5-777bb4.svg?style=flat-square&logo=php
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sermepa/sermepa.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sermepa/sermepa
[link-downloads]: https://packagist.org/packages/sermepa/sermepa
[link-author]: https://github.com/ssheduardo
[link-workflows]: https://github.com/ssheduardo/sermepa/actions/workflows/ci.yml
