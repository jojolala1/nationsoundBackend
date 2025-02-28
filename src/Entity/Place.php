<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
#[ApiResource]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['artiste:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column(length: 255)]
    private ?string $iconClass = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $opening = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $closing = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Artiste>
     */
    #[ORM\OneToMany(targetEntity: Artiste::class, mappedBy: 'place_id')]
    private Collection $artistes_id;

    public function __construct()
    {
        $this->artistes_id = new ArrayCollection();
    }

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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getIconClass(): ?string
    {
        return $this->iconClass;
    }

    public function setIconClass(string $iconClass): static
    {
        $this->iconClass = $iconClass;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getOpening(): ?\DateTimeImmutable
    {
        return $this->opening;
    }

    public function setOpening(\DateTimeImmutable $opening): static
    {
        $this->opening = $opening;

        return $this;
    }

    public function getClosing(): ?\DateTimeImmutable
    {
        return $this->closing;
    }

    public function setClosing(\DateTimeImmutable $closing): static
    {
        $this->closing = $closing;

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

    /**
     * @return Collection<int, Artiste>
     */
    public function getArtistesId(): Collection
    {
        return $this->artistes_id;
    }

    public function addArtistesId(Artiste $artistesId): static
    {
        if (!$this->artistes_id->contains($artistesId)) {
            $this->artistes_id->add($artistesId);
            $artistesId->setPlaceId($this);
        }

        return $this;
    }

    public function removeArtistesId(Artiste $artistesId): static
    {
        if ($this->artistes_id->removeElement($artistesId)) {
            // set the owning side to null (unless already changed)
            if ($artistesId->getPlaceId() === $this) {
                $artistesId->setPlaceId(null);
            }
        }

        return $this;
    }
}
