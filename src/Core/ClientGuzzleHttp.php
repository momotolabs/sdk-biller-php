<?php

namespace Momotolabs\SdkBiller\Core;

use GuzzleHttp\Client as Guzzle;

class ClientGuzzleHttp  {
    /**
     * Instancia de GuzzleHttp\Client
     * @var Guzzle
     */
    protected Guzzle $client;

    /**
     * Setup the client
     * 
     * Summary of __construct
     * @param Config $config
     */
    public function __construct(Config $config) {
        $this->client = new Guzzle([
            "base_uri" => $config->get("base_url"),
            "headers"=> array_merge([
                "Content-Type"=> "application/json",
                "Accept"=> "application/json",
            ], $config->get("headers") ?: []),
        ]);
    }

    public function get(string $url, array $query = []) {
        $response = $this->client->get($url, [
            "query" => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function post(string $url, array $data = []) {
        $response = $this->client->post($url, [
            "json" => $data,
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}