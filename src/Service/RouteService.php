<?php

declare(strict_types=1);

namespace App\Service;

use App\Provider\CountryProviderInterface;

final class RouteService implements RouteServiceInterface
{
    /**
     * @inheritDoc
     */
    public function findRoute(CountryProviderInterface $countryProvider, string $origin, string $destination): ?array
    {
        if ($origin === $destination) {
            return [$origin];
        }

        $countriesData = $countryProvider->getCountriesData();
        if (\count($countriesData) === 0) {
            return null;
        }

        $visited = [];
        $queue = new \SplQueue();
        $queue->enqueue([$origin]);

        while (!$queue->isEmpty()) {
            $path = $queue->dequeue();
            $lastCountry = end($path);

            if (!isset($visited[$lastCountry])) {
                $visited[$lastCountry] = true;

                foreach ($countriesData as $country) {
                    if ($country['cca3'] === $lastCountry) {
                        foreach ($country['borders'] as $border) {
                            if ($border === $destination) {
                                $path[] = $destination;
                                return $path;
                            }
                            if (!isset($visited[$border])) {
                                $newPath = $path;
                                $newPath[] = $border;
                                $queue->enqueue($newPath);
                            }
                        }
                    }
                }
            }
        }

        return null;
    }
}
