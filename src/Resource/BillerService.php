<?php

namespace Momotolabs\SdkBiller\Resource;

use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Momotolabs\SdkBiller\Resource\DTO\FE\FE;
use Momotolabs\SdkBiller\Resource\Interfaces\DTE;

class BillerService
{
    public function __construct(
        protected ClientGuzzleHttp $client
    ) {
    }

    public function send(DTE $factura): array
    {
        $payload = $factura->toArray();

        $endpoint = match (true) {
            $factura instanceof FE => 'ebill/FE',
            default => 'ebill/unknown'
        };

        return $this->client->post($endpoint, $payload);
    }
}