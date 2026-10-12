<?php

namespace App\Entity;

use App\Repository\CarrouselRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CarrouselRepository::class)]
#[UniqueEntity(
    fields: ['ordreCarrousel'],
    message: '/!\ Cet ordre est déjà utilisé dans le carrousel.'
)]
class Carrousel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true,unique: true)]
    #[Assert\Positive(
    message: '/!\ L’ordre doit être un nombre supérieur à 0.'
    )]
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienHelloasso = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $libelleBouton = null;

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
    
    public function getLienHelloasso(): ?string
    {
        return $this->lienHelloasso;
    }

    public function setLienHelloasso(?string $lienHelloasso): static
    {
        $this->lienHelloasso = $lienHelloasso;

        return $this;
    }

    public function getLibelleBouton(): ?string
    {
        return $this->libelleBouton;
    }

    public function setLibelleBouton(?string $libelleBouton): static
    {
        $this->libelleBouton = $libelleBouton;

        return $this;
    }

    #[Assert\Callback]
    public function validateLienUnique(ExecutionContextInterface $context): void
    {
        $liensRenseignes = 0;

        if ($this->offre !== null) {
            $liensRenseignes++;
        }

        if ($this->contenuEditorial !== null) {
            $liensRenseignes++;
        }

        if ($this->lienHelloasso !== null && trim($this->lienHelloasso) !== '') {
            $liensRenseignes++;
        }

        if ($liensRenseignes > 1) {
            $context->buildViolation(
                '/!\ Une slide ne peut être liée qu’à une seule destination : offre, contenu éditorial ou lien HelloAsso.'
            )
                ->atPath('lienHelloasso')
                ->addViolation();
        }
    }
}
