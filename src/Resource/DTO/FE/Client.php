<?php

namespace Momotolabs\SdkBiller\Resource\DTO\FE;

class Client {

    public function __construct(
        public ?string $nrc = null,
        public ?string $name = null,
        public ?string $phone = null,
        public ?string $email = null,
        public ?string $documentType = null,
        public ?string $documentNumber = null,
        public ?string $activityCode = null,
        public ?string $activityDesc = null,
        public ?Direction $direction = null
    ) {

    }

    public function toArray(): array
    {
        return [
            'nrc' => $this->nrc,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'documentType' => $this->documentType,
            'documentNumber' => $this->documentNumber,
            'activityCode' => $this->activityCode,
            'activityDesc' => $this->activityDesc,
            'direction' => $this->direction == null ? (new Direction())->toArray(): $this->direction->toArray()
        ];
    }
}