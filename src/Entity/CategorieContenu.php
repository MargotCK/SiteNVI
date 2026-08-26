<?php

namespace App\Entity;

use App\Repository\CategorieContenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieContenuRepository::class)]
class CategorieContenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $slug = null;

    /**
     * @var Collection<int, ContenuEditorial>
     */
    #[ORM\OneToMany(targetEntity: ContenuEditorial::class, mappedBy: 'categorieContenu')]
    private Collection $contenuEditorials;

    public function __construct()
    {
        $this->contenuEditorials = new ArrayCollection();
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

    /**
     * @return Collection<int, ContenuEditorial>
     */
    public function getContenuEditorials(): Collection
    {
        return $this->contenuEditorials;
    }

    public function addContenuEditorial(ContenuEditorial $contenuEditorial): static
    {
        if (!$this->contenuEditorials->contains($contenuEditorial)) {
            $this->contenuEditorials->add($contenuEditorial);
            $contenuEditorial->setCategorieContenu($this);
        }

        return $this;
    }

    public function removeContenuEditorial(ContenuEditorial $contenuEditorial): static
    {
        $this->contenuEditorials->removeElement($contenuEditorial);

        return $this;
    }
    
}
