<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $titre = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $horaires = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publicVise = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(options: ['default' => true])]
    private bool $actif = true;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateModification = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieOffre $categorieOffre = null;

    #[ORM\OneToOne(mappedBy: 'offre', cascade: ['persist', 'remove'])]
    private ?LienExterne $lienExterne = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Image $image = null;

    /**
     * @var Collection<int, Carrousel>
     */
    #[ORM\OneToMany(targetEntity: Carrousel::class, mappedBy: 'offre')]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getHoraires(): ?string
    {
        return $this->horaires;
    }

    public function setHoraires(?string $horaires): static
    {
        $this->horaires = $horaires;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPublicVise(): ?string
    {
        return $this->publicVise;
    }

    public function setPublicVise(?string $publicVise): static
    {
        $this->publicVise = $publicVise;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModification(): ?\DateTime
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTime $dateModification): static
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getCategorieOffre(): ?CategorieOffre
    {
        return $this->categorieOffre;
    }

    public function setCategorieOffre(CategorieOffre $categorieOffre): static
    {
        $this->categorieOffre = $categorieOffre;

        return $this;
    }

    public function getLienExterne(): ?LienExterne
    {
        return $this->lienExterne;
    }

    public function setLienExterne(LienExterne $lienExterne): static
    {
        // set the owning side of the relation if necessary
        if ($lienExterne->getOffre() !== $this) {
            $lienExterne->setOffre($this);
        }

        $this->lienExterne = $lienExterne;

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
            $carrousel->setOffre($this);
        }

        return $this;
    }

    public function removeCarrousel(Carrousel $carrousel): static
    {
        if ($this->carrousels->removeElement($carrousel)) {
            // set the owning side to null (unless already changed)
            if ($carrousel->getOffre() === $this) {
                $carrousel->setOffre(null);
            }
        }

        return $this;
    }

}
