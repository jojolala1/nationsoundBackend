<?php

namespace App\Tests\Unit;

use App\Entity\Artiste;
use PHPUnit\Framework\TestCase;
use App\Entity\Place;

class ArtisteTest extends TestCase
{
    private Artiste $artiste;
    public function setUp(): void
    {
        $this->artiste = new Artiste();
       
    }
    public function testGetName(): void
    {
        $value = 'name';

        $response = $this->artiste->setName($value);
        $getName = $this->artiste->getName();

        self::assertInstanceOf(Artiste::class, $response);
        self::assertEquals($value, $getName);
    }

    public function testGetDate(): void
    {
        $value = new \DateTimeImmutable();

        $response = $this->artiste->setDate($value);
        $getDate = $this->artiste->getDate();

        self::assertInstanceOf(Artiste::class, $response);
        self::assertEquals($value, $getDate);
    }

    public function testGetPlaceId(): void
    {
        $value = new Place();

        $response = $this->artiste->setPlaceId($value);
        $getPlaceId = $this->artiste->getPlaceId();

        self::assertInstanceOf(Artiste::class, $response);
        self::assertEquals($value, $getPlaceId);
    }

    public function testGetStageWithPlace(): void
    {
        // Crée une instance de Place avec un nom
        $place = new Place();
        $place->setName('Stage');

        // Associe le Place à l'Artiste
        $this->artiste->setPlaceId($place);

        // Vérifie que getStage() retourne le bon nom de la scène
        self::assertEquals('Stage', $this->artiste->getStage());
    }

    public function testGetStageWithNoPlace(): void
    {
        // Aucun Place associé
        $this->artiste->setPlaceId(null);

        // Vérifie que getStage() retourne null
        self::assertNull($this->artiste->getStage());
    }

    
}
