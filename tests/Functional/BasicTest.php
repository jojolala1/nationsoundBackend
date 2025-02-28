<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api');

        // Vérifie que la réponse a bien un code 200
        $this->assertResponseIsSuccessful();
    }
    
}
