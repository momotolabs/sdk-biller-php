<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

use Momotolabs\SdkBiller\Resource\DTO\Shared\PaymentItem;
use Momotolabs\SdkBiller\Resource\Interfaces\DTE;

class FE implements DTE
{
    /**
     * FE
     *
     * @param BodyItem[] $body Instancias de BodyItem
     * @param PaymentItem[] $payments Instancias de PaymentItem
     * @param int $operationCodition Código de operación
     * @throws \InvalidArgumentException Si algún elemento no es del tipo correcto
     */
    public function __construct(
        public ?Client $client,
        public array $body,
        public array $payments,
        public int $operationCondition
    ) {
    }

    public function toArray(): array
    {
        return [
            "receiver" => $this->client == null ? (new Client())->toArray() : $this->client->toArray(),
            "bodyBill" => array_map(fn(BodyItem $item) => $item->toArray(), $this->body),
            "operationCondition" => $this->operationCondition,
            "thirdSale" => null,
            "payments" => array_map(fn(PaymentItem $item) => $item->toArray(), $this->payments),
        ];
    }
}