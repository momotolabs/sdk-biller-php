<?php

use Momotolabs\SdkBiller\Core\ClientGuzzleHttp;
use Momotolabs\SdkBiller\Core\Config;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

it('realiza un GET y devuelve el JSON', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['success' => true])),
    ]);

    $handlerStack = HandlerStack::create($mock);

    // Config con base_url y headers
    $config = new Config([
        'base_url' => 'https://fake.api',
        'headers' => ['X-Test' => 'yes'],
        'client_id' => 'foo',
        'client_secret' => 'bar',
    ]);

    // Inyectar handler mockeado
    $client = new ClientGuzzleHttp($config);
    $reflection = new ReflectionClass($client);
    $prop = $reflection->getProperty('client');
    $prop->setAccessible(true);
    $prop->setValue($client, new Guzzle([
        'handler' => $handlerStack,
        'base_uri' => 'https://fake.api',
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Test' => 'yes',
        ],
    ]));

    $response = $client->get('/test', ['foo' => 'bar']);

    expect($response)->toBe(['success' => true]);
});

it('realiza un POST y devuelve el JSON', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['created' => true])),
    ]);

    $handlerStack = HandlerStack::create($mock);

    $config = new Config([
        'base_url' => 'https://fake.api',
        'client_id' => 'foo',
        'client_secret' => 'bar',
    ]);

    $client = new ClientGuzzleHttp($config);
    $reflection = new ReflectionClass($client);
    $prop = $reflection->getProperty('client');
    $prop->setAccessible(true);
    $prop->setValue($client, new Guzzle([
        'handler' => $handlerStack,
        'base_uri' => 'https://fake.api',
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ]));

    $response = $client->post('/users', ['name' => 'Cortez']);

    expect($response)->toBe(['created' => true]);
});
