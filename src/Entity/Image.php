<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_fichier = null;

    #[ORM\Column(length: 255)]
    private ?string $chemin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $texte_alternatif = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_upload = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): static
    {
        $this->nom_fichier = $nom_fichier;

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
        return $this->texte_alternatif;
    }

    public function setTexteAlternatif(?string $texte_alternatif): static
    {
        $this->texte_alternatif = $texte_alternatif;

        return $this;
    }

    public function getDateUpload(): ?\DateTimeImmutable
    {
        return $this->date_upload;
    }

    public function setDateUpload(\DateTimeImmutable $date_upload): static
    {
        $this->date_upload = $date_upload;

        return $this;
    }
}
