<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\CountryProviderInterface;
use App\Service\RouteServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoutingController extends AbstractController
{
    private RouteServiceInterface $routeService;
    private CountryProviderInterface $countryProvider;

    public function __construct(RouteServiceInterface $routeService, CountryProviderInterface $countryProvider)
    {
        $this->routeService = $routeService;
        $this->countryProvider = $countryProvider;
    }

    #[Route('/routing/{origin}/{destination}', name: 'calculate_route', methods: ['GET'])]
    public function calculateRoute(string $origin, string $destination): JsonResponse
    {
        $route = $this->routeService->findRoute($this->countryProvider, $origin, $destination);

        if ($route) {
            return new JsonResponse(['route' => $route]);
        }

        return new JsonResponse(['error' => 'No land crossing found'], 400);
    }
}
