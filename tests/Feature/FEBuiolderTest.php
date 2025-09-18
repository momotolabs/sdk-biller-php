<?php

use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Momotolabs\SdkBiller\Core\Config;
use Momotolabs\SdkBiller\Resource\BillerService;
use Momotolabs\SdkBiller\Resource\DTO\FE\BodyItem;
use Momotolabs\SdkBiller\Resource\DTO\Shared\PaymentItem;
use Momotolabs\SdkBiller\Resource\DTO\FE\FEBuilder;

test('feature send FE OK', function () {

    if (!$_ENV['BILLER_TOKEN'] || !$_ENV['BILLER_BASE_URL']) {
        $this->markTestSkipped('Se requieren BILLER_BASE_URL y BILLER_TOKEN para integración');
    }

    $config = new Config([
        'base_url' => $_ENV['BILLER_BASE_URL'],
        'headers' => [
            'Authorization' => 'Bearer ' . $_ENV['BILLER_TOKEN'],
            "X-Business-Id" => $_ENV['BILLER_BUSSINESS_ID'],
            "X-Pos-Id" => $_ENV['BILLER_POS_ID'],
            "X-Member-Code" => $_ENV['BILLER_MEMBER_CODE'],
        ],
    ]);

    $client = new ClientGuzzleHttp($config);
    $service = new BillerService($client);

    $fe = (new FEBuilder())
        ->addBodyItem(
            new BodyItem(
                itemType: 1,
                quantity: 1,
                unitMeasure: 99,
                code: "1234",
                description: 'Producto 1',
                unitPrice: 100.00,
                taxes: null
            ),
        )->addPaymentItem(
            new PaymentItem(
                code: "02",
                term: "01",
                reference: "4081151108",
            )
        )->withOperationCondition(1);

    $response = $service->send($fe->build());

    expect($response)
        ->toHaveKey('data.selloRecepcion')
        ->and($response)
        ->toHaveKey('success', true);
});
