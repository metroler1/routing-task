<?php

namespace App\Service;
use App\Provider\CountryProviderInterface;

interface RouteServiceInterface
{
    /**
     * @param CountryProviderInterface $countryProvider
     * @param string $origin
     * @param string $destination
     * @return string[]|null
     */
    public function findRoute(CountryProviderInterface $countryProvider, string $origin, string $destination): ?array;
}
