<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ArtisteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
#[Get()]
#[GetCollection()]
#[Post(
    denormalizationContext: ['groups' => ['artiste:create']]
)]
#[Delete()]
#[Patch(
    denormalizationContext: ['groups' => ['artiste:modify']]
)]
#[Vich\Uploadable]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['artiste:create', 'artiste:modify', 'artiste:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[ApiFilter(DateFilter::class, properties: ['date'])]
    #[Groups(['artiste:create', 'artiste:modify', 'artiste:read'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    #[Groups(['artiste:create', 'artiste:modify', 'artiste:read'])]
    private ?\DateTimeImmutable $time = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artiste:create', 'artiste:modify', 'artiste:read'])]
    private ?string $style = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['artiste:create', 'artiste:modify', 'artiste:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artiste:create', 'artiste:modify', 'artiste:read'])]
    private ?string $videoLink = null;

    #[Vich\UploadableField(mapping: 'artiste', fileNameProperty: 'imageName')]
    #[Groups(['artiste:create', 'artiste:modify'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'artistes_id')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['artiste:read', 'artiste:create', 'artiste:modify'])]
    private ?Place $place_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(\DateTimeImmutable $time): static
    {
        $this->time = $time;
        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(string $videoLink): static
    {
        $this->videoLink = $videoLink;
        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getPlaceId(): ?Place
    {
        return $this->place_id;
    }

    public function setPlaceId(?Place $place_id): static
    {
        $this->place_id = $place_id;
        return $this;
    }

    // Ajout du getter dynamique pour le stage
    #[Groups(['artiste:read'])]
    public function getStage(): ?string
    {
        return $this->place_id?->getName();
    }
}
