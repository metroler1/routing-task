<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CountryProvider implements CountryProviderInterface
{
    private HttpClientInterface $httpClient;
    private string $countriesJsonUrl;

    public function __construct(HttpClientInterface $httpClient, string $params)
    {
        $this->httpClient = $httpClient;
        $this->countriesJsonUrl = $params;
    }

    public function getCountriesData(): array
    {
        try {
            $response = $this->httpClient->request('GET', $this->countriesJsonUrl);
            return $response->toArray();
        } catch (\Throwable) {
            // Handle exception, for example, log an error and return an empty array
            return [];
        }
    }
}
