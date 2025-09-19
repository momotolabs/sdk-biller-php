<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

use InvalidArgumentException;
use Momotolabs\SdkBiller\Resource\DTO\FE\BodyItem;
use Momotolabs\SdkBiller\Resource\DTO\Shared\PaymentItem;
use Momotolabs\SdkBiller\Resource\DTO\Shared\RelatedDocument;
use Momotolabs\SdkBiller\Resource\DTO\Shared\ThirdSale;

class FEBuilder
{
    private ?Client $client = null;
    private array $body = [];
    private array $payments = [];
    private int $operationCondition;
    private array $relatedDocuments = [];
    private array $thirdSale = [];

    public function __construct(int $operationCondition = 1)
    {
        $this->operationCondition = $operationCondition;
        $this->relatedDocuments = [];
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

    public function addRelatedDocument(RelatedDocument $document): self
    {
        array_push($this->relatedDocuments, $document);
        return $this;
    }

    public function addThirdSale(ThirdSale $item): self
    {
        array_push($this->thirdSale, $item);
        return $this;
    }

    public function build(): FE
    {
        $relatedDocuments = array_count_values($this->relatedDocuments) > 0 ? $this->relatedDocuments : null;
        $thirdSale = array_count_values($this->thirdSale) > 0 ? $this->thirdSale : null;

        return new FE(
            $this->client,
            $this->body,
            $this->payments,
            $this->operationCondition,
            $relatedDocuments,
            $thirdSale
        );
    }
}