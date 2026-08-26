<?php

namespace App\Entity;

use App\Repository\ContenuEditorialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContenuEditorialRepository::class)]
class ContenuEditorial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $titre = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $resume = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(length: 160, nullable: true)]
    private ?string $meta_description = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $actif = true;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creation = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date_modification = null;

    #[ORM\ManyToOne(inversedBy: 'contenuEditorials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieContenu $categorieContenu = null;

    #[ORM\ManyToOne(inversedBy: 'contenuEditorials')]
    private ?Image $image = null;

    /**
     * @var Collection<int, Carrousel>
     */
    #[ORM\OneToMany(targetEntity: Carrousel::class, mappedBy: 'contenuEditorial')]
    private Collection $carrousels;

    public function __construct()
    {
        $this->carrousels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): static
    {
        $this->meta_description = $meta_description;

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


    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeImmutable $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateModification(): ?\DateTime
    {
        return $this->date_modification;
    }

    public function setDateModification(?\DateTime $date_modification): static
    {
        $this->date_modification = $date_modification;

        return $this;
    }

    public function getCategorieContenu(): ?CategorieContenu
    {
        return $this->categorieContenu;
    }

    public function setCategorieContenu(CategorieContenu $categorieContenu): static
    {
        $this->categorieContenu = $categorieContenu;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Carrousel>
     */
    public function getCarrousels(): Collection
    {
        return $this->carrousels;
    }

    public function addCarrousel(Carrousel $carrousel): static
    {
        if (!$this->carrousels->contains($carrousel)) {
            $this->carrousels->add($carrousel);
            $carrousel->setContenuEditorial($this);
        }

        return $this;
    }

    public function removeCarrousel(Carrousel $carrousel): static
    {
        if ($this->carrousels->removeElement($carrousel)) {
            // set the owning side to null (unless already changed)
            if ($carrousel->getContenuEditorial() === $this) {
                $carrousel->setContenuEditorial(null);
            }
        }

        return $this;
    }
}
