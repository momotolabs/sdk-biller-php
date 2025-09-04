<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

class PaymentItem {
    public function __construct(
        public string $code,
        public ?string $term = null,
        public ?string $reference = null,
        public ?int $period = null
        ) {
        
    }

    public function toArray(): array {
        return [
            "code" => $this->code,
            "term" => $this->term,
            "reference" => $this->reference,
            "period" => $this->period
        ];
    }
}