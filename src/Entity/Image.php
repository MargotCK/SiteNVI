<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 191,unique: true)]
    private ?string $nomFichier = null;

    #[ORM\Column(length: 500)]
    private ?string $chemin = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $texteAlternatif = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateUpload = null;

    /**
     * @var Collection<int, Offre>
     */
    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: 'image')]
    private Collection $offres;

    /**
     * @var Collection<int, ContenuEditorial>
     */
    #[ORM\OneToMany(targetEntity: ContenuEditorial::class, mappedBy: 'image')]
    private Collection $contenuEditorials;

    /**
     * @var Collection<int, Carrousel>
     */
    #[ORM\OneToMany(targetEntity: Carrousel::class, mappedBy: 'image')]
    private Collection $carrousels;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->contenuEditorials = new ArrayCollection();
        $this->carrousels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): static
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): static
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getTexteAlternatif(): ?string
    {
        return $this->texteAlternatif;
    }

    public function setTexteAlternatif(?string $texteAlternatif): static
    {
        $this->texteAlternatif = $texteAlternatif;

        return $this;
    }

    public function getDateUpload(): ?\DateTimeImmutable
    {
        return $this->dateUpload;
    }

    public function setDateUpload(\DateTimeImmutable $dateUpload): static
    {
        $this->dateUpload = $dateUpload;

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): static
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setImage($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getImage() === $this) {
                $offre->setImage(null);
            }
        }

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
            $contenuEditorial->setImage($this);
        }

        return $this;
    }

    public function removeContenuEditorial(ContenuEditorial $contenuEditorial): static
    {
        if ($this->contenuEditorials->removeElement($contenuEditorial)) {
            // set the owning side to null (unless already changed)
            if ($contenuEditorial->getImage() === $this) {
                $contenuEditorial->setImage(null);
            }
        }

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
            $carrousel->setImage($this);
        }

        return $this;
    }

    public function removeCarrousel(Carrousel $carrousel): static
    {
        $this->carrousels->removeElement($carrousel);

        return $this;
    }

    
}
