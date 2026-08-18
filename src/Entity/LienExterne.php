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
    private ?string $urlHelloasso = null;

    #[ORM\Column]
    private ?bool $actif = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }
}
