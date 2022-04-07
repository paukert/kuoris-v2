<?php

namespace App\Client;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrisClient
{
    private HttpClientInterface $httpClient;

    private const DATA_FORMAT = 'json'; // available formats could be found in docs: https://oris.orientacnisporty.cz/API/
    private const BASE_URL = 'https://oris.orientacnisporty.cz/API/?format=' . self::DATA_FORMAT . '&method=';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[ArrayShape(['statusCode' => 'int', 'body' => 'array'])]
    private function sendRequest(string $method, string $url, array $options = []): array
    {
        $response = $this->httpClient->request($method, $url, $options);

        return [
            'statusCode' => $response->getStatusCode(),
            'body' => $response->toArray(),
        ];
    }

    public function getRaceData(int $orisId): ?array
    {
        $response = $this->sendRequest(
            Request::METHOD_GET,
            self::BASE_URL . 'getEvent&id=' . $orisId
        );

        if ($response['statusCode'] !== Response::HTTP_OK) {
            return null;
        }

        return $response['body'];
    }
}
