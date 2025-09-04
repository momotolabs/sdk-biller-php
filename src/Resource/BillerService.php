<?php

namespace Momotolabs\SdkBiller\Resource;

use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Src\Resource\DTO\FE\FEBuilder;

class BillerService {
    public function __construct(
        protected ClientGuzzleHttp $client
    ) {}

    public function fe(FEBuilder|array $factura): array {
        $payload = $factura instanceof ApiResource
            ? $factura->toArray()
            : $factura;

        return $this->client->post('/ebill/FE', $payload);
    }
}