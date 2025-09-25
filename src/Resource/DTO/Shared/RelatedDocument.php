<?php

namespace Momotolabs\SdkBiller\Resource\DTO\Shared;

use DateTime;
use Momotolabs\SdkBiller\Resource\Interfaces\DTE;

class RelatedDocument implements DTE
{
    public function __construct(
        public string $documentType,
        public int $generationType,
        public string $documentNumber,
        public DateTime $date
    ) {
    }

    public function toArray(): array
    {
        return [
            "typeDocument" => $this->documentType,
            "generationType" => $this->generationType,
            "documentNumber" => $this->documentNumber,
            "date" => $this->date->format('Y-m-d')
        ];
    }
}