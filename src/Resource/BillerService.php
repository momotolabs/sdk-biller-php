<?php

namespace Momotolabs\SdkBiller\Resource;

use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Momotolabs\SdkBiller\Resource\DTO\FE\FEBuilder;

class BillerService {
    public function __construct(
        protected ClientGuzzleHttp $client
    ) {}

    public function sendFe(FEBuilder|array $factura): array {
        $payload = $factura instanceof FEBuilder
            ? $factura->toArray()
            : $factura;

        return $this->client->post('ebill/FE', $payload);
    }
}