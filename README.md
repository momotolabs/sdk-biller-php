# 📦 SDK Biller

**SDK Biller** es una librería PHP desarrollada por **Momotolabs** para facilitar la integración con la **API de Biller**, permitiendo la **creación y envío de facturas electrónicas** al **Ministerio de Hacienda** de forma simple y estandarizada.  

Su propósito es **abstraer la complejidad técnica** de las conexiones y proveer métodos fáciles de usar para interactuar con el sistema de facturación.  

## ✨ Características  

- 🔗 Conexión rápida y sencilla a la API de Biller.  
- 🧾 Creación de facturas electrónicas en pocos pasos.  
- ⚡ Manejo centralizado de configuración y autenticación.  
- 📚 Uso de DTOs y Builders para garantizar consistencia en la construcción de documentos.  

## 📦 Instalación

Instala el paquete vía [Composer](https://getcomposer.org/):  

```bash
composer require momotolabs/sdk-biller
```

## 🚀 Quickstart

La configuración del SDK se realiza mediante un arreglo de opciones, que pueden ser cargadas desde variables de entorno ```.env``` o archivos ```.php``` y ```.json```.

### Configuración con variables de entorno

```php
use Momotolabs\SdkBiller\Core\Config;

$settings = [
    'base_url' => $_ENV['BILLER_BASE_URL'],
    'headers' => [
        "X-Business-Id" => $_ENV['BILLER_BUSSINESS_ID'],
        "X-Pos-Id" => $_ENV['BILLER_POS_ID'],
        "X-Member-Code" => $_ENV['BILLER_MEMBER_CODE'],
    ],
    'client_id' => $_ENV['BILLER_CLIENT_ID'],
    'client_secret' => $_ENV['BILLER_CLIENT_SECRET'],
];

$config = new Config($settings);
```

El objeto ```Config``` centraliza la configuración y será usado por el cliente HTTP del SDK.

### Iniciar servicio de facturación

```php
use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Momotolabs\SdkBiller\Resource\BillerService;

$client = new ClientGuzzleHttp($config);
$service = new BillerService($client);
```

### Construccion de la factura

Ejemplo de contruccion de una factura de consumudor final

```php
use Momotolabs\SdkBiller\Resource\DTO\FE\BodyItem;
use Momotolabs\SdkBiller\Resource\DTO\Shared\PaymentItem;
use Momotolabs\SdkBiller\Resource\DTO\FE\FEBuilder;

$fe = (new FEBuilder())
    ->addBodyItem(
        new BodyItem(
            itemType: 1,
            quantity: 1,
            unitMeasure: 99,
            code: "1234",
            description: 'Producto 1',
            unitPrice: 100.00
        ),
    )->addPaymentItem(
        new PaymentItem(
            code: "02",
            term: "01",
            reference: "4081151108",
        )
    )->withOperationCondition(1);

$service->send($fe->build());
```

## 📚 Documentación

Para obtener información detallada sobre las funciones y métodos disponibles, consulte la documentación.
