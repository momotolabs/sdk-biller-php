<?php

use Momotolabs\SdkBiller\Core\Config;

it('carga configuración desde un array', function () {
    $config = new Config(['foo' => 'bar']);
    expect($config->get('foo'))->toBe('bar');
    expect($config->all())->toBe(['foo' => 'bar']);
});

it('carga configuración desde un archivo php', function () {
    $path = __DIR__ . '/../fixtures/config.php';
    file_put_contents($path, "<?php return ['db' => 'mysql'];");

    $config = new Config($path);
    expect($config->get('db'))->toBe('mysql');

    unlink($path);
});

it('carga configuración desde un archivo json', function () {
    $path = __DIR__ . '/../fixtures/config.json';
    file_put_contents($path, json_encode(['api' => 'v1']));

    $config = new Config($path);
    expect($config->get('api'))->toBe('v1');

    unlink($path);
});

it('lanza excepción con formato no soportado', function () {
    $path = __DIR__ . '/../fixtures/config.txt';
    file_put_contents($path, "invalid");

    expect(fn () => new Config($path))
        ->toThrow(InvalidArgumentException::class, "Formato de config no soportado: $path");

    unlink($path);
});

it('lanza excepción con config inválida', function () {
    expect(fn () => new Config(123))
        ->toThrow(InvalidArgumentException::class, "Config inválida");
});

it('devuelve el valor por defecto si la clave no existe', function () {
    $config = new Config(['foo' => 'bar']);
    expect($config->get('missing', 'default'))->toBe('default');
});
