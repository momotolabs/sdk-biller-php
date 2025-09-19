<?php
namespace Momotolabs\SdkBiller\Resource\DTO\Shared;

use Momotolabs\SdkBiller\Resource\Interfaces\DTE;

class ThirdSale implements DTE
{
    public ?string $nit = null;
    public ?string $name = null;

    public function toArray(): array
    {
        return [
            "nit" => $this->nit,
            "name" => $this->name,
        ];
    }
}