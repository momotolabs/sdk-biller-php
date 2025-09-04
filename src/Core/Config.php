<?php

namespace Src\Core;

class Config
{
    protected array $settings;

    public function __construct(array|string $config)
    {
        if (is_string($config) && file_exists($config)) {
            if (str_ends_with($config, '.php')) {
                $this->settings = require $config;
            } elseif (str_ends_with($config, '.json')) {
                $this->settings = json_decode(file_get_contents($config), true);
            } else {
                throw new \InvalidArgumentException("Formato de config no soportado: $config");
            }
        } elseif (is_array($config)) {
            $this->settings = $config;
        } else {
            throw new \InvalidArgumentException("Config inválida");
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->settings;
    }
}