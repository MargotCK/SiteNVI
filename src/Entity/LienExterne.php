<?php

namespace App\Entity;

use App\Repository\LienExterneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LienExterneRepository::class)]
class LienExterne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 500)]
    private ?string $urlHelloasso = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $actif = true;

    #[ORM\OneToOne(inversedBy: 'lienExterne', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false,unique: true)]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(inversedBy: 'lienExternes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieLien $categorieLien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getUrlHelloasso(): ?string
    {
        return $this->urlHelloasso;
    }

    public function setUrlHelloasso(string $urlHelloasso): static
    {
        $this->urlHelloasso = $urlHelloasso;

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

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    public function getCategorieLien(): ?CategorieLien
    {
        return $this->categorieLien;
    }

    public function setCategorieLien(CategorieLien $categorieLien): static
    {
        $this->categorieLien = $categorieLien;

        return $this;
    }
}
