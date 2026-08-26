<?php

namespace App\Entity;

use App\Repository\CategorieLienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieLienRepository::class)]
class CategorieLien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $slug = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $actif = true;

    /**
     * @var Collection<int, LienExterne>
     */
    #[ORM\OneToMany(targetEntity: LienExterne::class, mappedBy: 'categorieLien')]
    private Collection $lienExternes;

    public function __construct()
    {
        $this->lienExternes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    /**
     * @return Collection<int, LienExterne>
     */
    public function getLienExternes(): Collection
    {
        return $this->lienExternes;
    }

    public function addLienExterne(LienExterne $lienExterne): static
    {
        if (!$this->lienExternes->contains($lienExterne)) {
            $this->lienExternes->add($lienExterne);
            $lienExterne->setCategorieLien($this);
        }

        return $this;
    }

    public function removeLienExterne(LienExterne $lienExterne): static
    {
        $this->lienExternes->removeElement($lienExterne);

        return $this;
    }

    
}
