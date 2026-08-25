<?php

namespace App\Entity;

use App\Repository\CarrouselRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrouselRepository::class)]
class Carrousel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true,unique: true)]
    private ?int $ordreCarrousel = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $actif = true;

    #[ORM\ManyToOne(inversedBy: 'carrousels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'carrousels')]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(inversedBy: 'carrousels')]
    private ?ContenuEditorial $contenuEditorial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdreCarrousel(): ?int
    {
        return $this->ordreCarrousel;
    }

    public function setOrdreCarrousel(?int $ordreCarrousel): static
    {
        $this->ordreCarrousel = $ordreCarrousel;

        return $this;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    public function getContenuEditorial(): ?ContenuEditorial
    {
        return $this->contenuEditorial;
    }

    public function setContenuEditorial(?ContenuEditorial $contenuEditorial): static
    {
        $this->contenuEditorial = $contenuEditorial;

        return $this;
    }
}
