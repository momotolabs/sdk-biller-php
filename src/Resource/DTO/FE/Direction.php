<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

class Direction {
    public function __construct(
        public ?string $city = null,
        public ?string $state = null,
        public ?string $complement = null
        ) {
    }

    public function toArray(): array {
        return [
            'city' => $this->city,
            'state' => $this->state,
            'complement' => $this->complement
        ];
    }
}