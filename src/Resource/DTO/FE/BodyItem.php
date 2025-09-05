<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

class BodyItem {
    public function __construct(
        public int $itemType,
        public float $quantity,
        public int $unitMeasure,
        public string $description,
        public float $unitPrice = 0.00,
        public float $discount = 0.00,
        public bool $nonSujSale = false,
        public bool $exemptSale = false,
        public float $noTax = 0.00,
        public ?string $documentNumber = null,
        public ?string $code = null,
        public ?string $taxCode = null,
        public ?array $taxes = []
    ) {}


    public function toArray(): array {
        return [
            "itemType" => $this->itemType,
            "quantity" => $this->quantity,
            "unitMeasure" => $this->unitMeasure,
            "description" => $this->description,
            "unitPrice" => $this->unitPrice,
            "discount" => $this->discount,
            "nonSujSale" => $this->nonSujSale,
            "exemptSale" => $this->exemptSale,
            "noTax" => $this->noTax,
            "documentNumber" => $this->documentNumber,
            "code" => $this->code,
            "taxCode" => $this->taxCode,
            "taxes" => $this->taxes
        ];
    }
}