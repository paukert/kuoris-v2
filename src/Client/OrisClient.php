<?php

namespace App\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrisClient
{
    private HttpClientInterface $httpClient;

    private const BASE_URL = 'https://oris.orientacnisporty.cz/API/';
    private const DATA_FORMAT = 'json'; // available formats could be found in docs: https://oris.orientacnisporty.cz/API/

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getRaceData(int $orisId): ?array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            self::BASE_URL . '?format=' . self::DATA_FORMAT . '&method=getEvent&id=' . $orisId
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return null;
        }

        return $response->toArray();
    }
}
