<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutingControllerTest extends WebTestCase
{
    public function testValidRoute(): void
    {
        $client = static::createClient();

        $client->request('GET', '/routing/CZE/ITA');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"route": ["CZE", "AUT", "ITA"]}', $client->getResponse()->getContent());
    }

    public function testInvalidRoute(): void
    {
        $client = static::createClient();

        $client->request('GET', '/routing/CZE/USA');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error": "No land crossing found"}', $client->getResponse()->getContent());
    }
}
