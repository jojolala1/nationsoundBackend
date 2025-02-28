<?php

namespace App\Tests\Unit;

use App\Entity\Artiste;
use App\Entity\Place;
use PHPUnit\Framework\TestCase;

class PlaceTest extends TestCase
{
    private Place $place;
    public function testGetName(): void
    {
        $this->place = new Place();
        $value = 'name';

        $response = $this->place->setName($value);
        $getName = $this->place->getName();

        self::assertInstanceOf(Place::class, $response);
        self::assertEquals($value, $getName);
    }

    public function testAddAndRemoveArtiste(): void
    {
        $artiste = new Artiste();
        $place = new Place();

        $place->addArtistesId($artiste);
        $this->assertCount(1, $place->getArtistesId());
        $this->assertSame($place, $artiste->getPlaceId());

        $place->removeArtistesId($artiste);
        $this->assertCount(0, $place->getArtistesId());
        $this->assertNull($artiste->getPlaceId());
    }
}
