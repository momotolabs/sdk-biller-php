<?php

namespace Momotolabs\SdkBiller\Resource\Interfaces;

interface TokenStorageInterface
{
    public function getToken(): ?string;
    public function saveToken(string $token, int $expiresIn): void;
    public function clear(): void;
}