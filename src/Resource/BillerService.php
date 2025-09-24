<?php

namespace Momotolabs\SdkBiller\Resource;

use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Momotolabs\SdkBiller\Resource\DTO\FE\FE;
use Momotolabs\SdkBiller\Resource\Interfaces\DTE;

class BillerService
{
    public function __construct(
        protected ClientGuzzleHttp $clientGuzzle
    ) {
    }

    public function send(DTE $factura): array
    {
        $payload = $factura->toArray();

        $endpoint = match (true) {
            $factura instanceof FE => 'ebill/FE',
            default => 'ebill/unknown'
        };

        return $this->clientGuzzle->post($endpoint, $payload);
    }

    public function loginInBiller($clientId, $clientSecret): void
    {
        $response = $this->clientGuzzle->post('oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => '*',
        ]);
    }
}