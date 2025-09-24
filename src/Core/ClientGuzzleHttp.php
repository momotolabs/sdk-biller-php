<?php

namespace Momotolabs\SdkBiller\Core;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use Momotolabs\SdkBiller\Resource\Interfaces\TokenStorageInterface;

class ClientGuzzleHttp
{
    /**
     * Instancia de GuzzleHttp\Client
     * @var Guzzle
     */
    protected Guzzle $client;
    protected string $clientId;
    protected string $clientSecret;
    protected TokenStorageInterface $storage;

    /**
     * Setup the client
     * 
     * Summary of __construct
     * @param Config $config
     */
    public function __construct(Config $config, ?TokenStorageInterface $tokenStorage = null)
    {
        $this->client = new Guzzle([
            "base_uri" => $config->get("base_url"),
            "headers" => array_merge([
                "Content-Type" => "application/json",
                "Accept" => "application/json",
            ], $config->get("headers") ?: []),
        ]);

        $this->clientId = $config->get("client_id");
        $this->clientSecret = $config->get("client_secret");

        $this->storage = $storage ?? new InMemoryTokenStorage();

        if ($token = $this->storage->getToken()) {
            $this->updateClientAuthorizationHeader($token);
        }
    }

    public function get(string $url, array $query = [])
    {
        try {
            $response = $this->client->get($url, [
                "query" => $query
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $this->retryUnAuthorizedRequest($e, fn() => $this->client->get($url, [
                "query" => $query
            ]));

            throw $e;
        }
    }

    public function post(string $url, array $data = [])
    {
        try {
            $response = $this->client->post($url, [
                "json" => $data,
            ]);

            $dataDecoded = json_decode($response->getBody()->getContents(), true);

            return $dataDecoded;
        } catch (ClientException $e) {
            $response = $this->retryUnAuthorizedRequest(
                $e,
                fn() => $this->client->post($url, [
                    "json" => $data
                ])->getBody()->getContents()
            );

            if ($response) {
                return json_decode($response, true);
            }

            throw $e;
        }
    }

    public function loginInBiller()
    {
        $response = $this->client->post("oauth/token", [
            "form_params" => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => '*',
            ]
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        $this->updateClientAuthorizationHeader($response['access_token']);
    }

    private function retryUnAuthorizedRequest(ClientException $e, callable $function)
    {
        if ($e->getResponse() && $e->getResponse()->getStatusCode() === 401) {
            try {
                $this->loginInBiller();

                return $function();
            } catch (\Throwable $refreshError) {
                throw $refreshError;
            }
        }

        throw $e;
    }

    private function updateClientAuthorizationHeader($dataResponse)
    {
        if ($dataResponse == null) {
            throw new \RuntimeException("No se pudo refrescar el token: respuesta inválida");
        }

        $token = $dataResponse;

        $config = $this->client->getConfig();

        $config['headers']['Authorization'] = "Bearer {$token}";

        $this->client = new Guzzle($config);
    }
}