<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MaladieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaladieRepository::class)]
#[ApiResource]
#[UniqueEntity('nom')]
#[ApiFilter(SearchFilter::class, properties: ['categorie' => 'exact', 'gravite' => 'exact'])]
class Maladie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Le nom est requis',
    )]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Le nom doit faire au moins {{ limit }} caractères",
        maxMessage: "Le nom ne doit pas faire plus que {{ limit }} caractères"
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "La categorie doit faire au moins {{ limit }} caractères",
        maxMessage: "La categorie ne doit pas faire plus que {{ limit }} caractères"
    )]
    #[Assert\NotBlank(
        message: 'La categorie est requis',
    )]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "La gravite doit faire au moins {{ limit }} caractères",
        maxMessage: "La gravite ne doit pas faire plus que {{ limit }} caractères"
    )]
    #[Assert\NotBlank(
        message: 'La gravite est requis',
    )]
    private ?string $gravite = null;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getGravite(): ?string
    {
        return $this->gravite;
    }

    public function setGravite(string $gravite): static
    {
        $this->gravite = $gravite;

        return $this;
    }
}
