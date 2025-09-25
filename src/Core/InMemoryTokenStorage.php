<?php

namespace Momotolabs\SdkBiller\Core;

use Momotolabs\SdkBiller\Resource\Interfaces\TokenStorageInterface;

class InMemoryTokenStorage implements TokenStorageInterface
{
    private ?string $token = null;
    private ?int $expiresAt = null;

    public function getToken(): ?string
    {
        if ($this->expiresAt !== null && time() > $this->expiresAt) {
            return null;
        }
        return $this->token;
    }

    public function saveToken(string $token, int $expiresIn): void
    {
        $this->token = $token;
        $this->expiresAt = time() + $expiresIn;
    }

    public function clear(): void
    {
        $this->token = null;
        $this->expiresAt = null;
    }
}