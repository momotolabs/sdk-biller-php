<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

use InvalidArgumentException;
use Momotolabs\SdkBiller\Resource\DTO\FE\BodyItem;
use Momotolabs\SdkBiller\Resource\DTO\Shared\PaymentItem;

class FEBuilder
{
    private ?Client $client = null;
    private array $body = [];
    private array $payments = [];
    private int $operationCondition;

    public function __construct(int $operationCondition = 1)
    {
        $this->operationCondition = $operationCondition;
    }

    public function withClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function addBodyItem(BodyItem $item): self
    {
        if (!$item instanceof BodyItem) {
            throw new InvalidArgumentException('Todos los elementos de body deben ser instancias de BodyItem.');
        }
        $this->body[] = $item;
        return $this;
    }

    public function addPaymentItem(PaymentItem $item): self
    {
        if (!$item instanceof PaymentItem) {
            throw new InvalidArgumentException('Todos los elementos de payments deben ser instancias de PaymentItem.');
        }
        $this->payments[] = $item;
        return $this;
    }

    public function withOperationCondition(int $condition): self
    {
        $this->operationCondition = $condition;
        return $this;
    }

    public function build(): FE
    {
        return new FE(
            $this->client,
            $this->body,
            $this->payments,
            $this->operationCondition
        );
    }
}