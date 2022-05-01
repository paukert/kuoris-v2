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
    private const SPORT_OB = 1;

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

        if ($response['statusCode'] !== Response::HTTP_OK
            || !isset($response['body']['Status'])
            || $response['body']['Status'] !== 'OK') {
            return null;
        }

        return $response['body'];
    }

    public function sendEntry(array $parameters): bool
    {
        $url = self::BASE_URL . 'createEntry';

        foreach ($parameters as $parameterName => $parameterValue) {
            $url .= '&' . $parameterName . '=' . $parameterValue;
        }

        $response = $this->sendRequest(Request::METHOD_GET, $url);

        if ($response['statusCode'] !== Response::HTTP_OK
            || !isset($response['body']['Status'])
            || $response['body']['Status'] !== 'OK') {
            return false;
        }

        return true;
    }

    public function getListOfEvents(string $dateTo): ?array
    {
        $now = (new \DateTime('now'))->format('Y-m-d');
        $response = $this->sendRequest(
            Request::METHOD_GET,
            self::BASE_URL . 'getEventList&sport=' . self::SPORT_OB . '&datefrom=' . $now . '&dateto=' . $dateTo
        );

        if ($response['statusCode'] !== Response::HTTP_OK
            || !isset($response['body']['Status'])
            || $response['body']['Status'] !== 'OK') {
            return null;
        }

        return $response['body'];
    }
}
