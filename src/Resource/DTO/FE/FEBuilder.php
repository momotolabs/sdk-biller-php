<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

use InvalidArgumentException;
use Momotolabs\SdkBiller\Resource\DTO\FE\BodyItem;
use Momotolabs\SdkBiller\Resource\DTO\Shared\PaymentItem;

class FEBuilder {
    
    /**
     * FEBuilder constructor.
     *
     * @param BodyItem[] $body Instancias de BodyItem
     * @param PaymentItem[] $payments Instancias de PaymentItem
     * @param int $operationCodition Código de operación
     * @throws InvalidArgumentException Si algún elemento no es del tipo correcto
     */
    public function __construct(
        public array $body,
        public array $payments,
        public int $operationCodition
    ) {
        foreach ($body as $item) {
            if (!$item instanceof BodyItem) throw new InvalidArgumentException('Todos los elementos de body deben ser instancias de BodyItem.');
        }

        foreach ($payments as $paymentItem) {
            if (!$paymentItem instanceof PaymentItem) throw new InvalidArgumentException('Todos los elementos de payments deben ser instancias de PaymentItem.');
        }
    }


    public function toArray(): array {
        return [
            "receiver" => null,
            "bodyBill" => array_map(fn (BodyItem $item) => $item->toArray(), $this->body),
            "operationCondition" => $this->operationCodition,
            "thirdSale" => null,
            "payments" => array_map(fn (PaymentItem $item) => $item->toArray(), $this->payments),
        ];
    }
}