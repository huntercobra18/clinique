<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ApiResource]
#[UniqueEntity('nom')]
#[ApiFilter(SearchFilter::class, properties: ['specialite' => 'partial', 'nom' => 'partial'])]
class Medecin
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
    #[Assert\Choice(
        ['cardiologue', 'kiné',"generaliste"],
        message: 'Type de spécialité est invalide'
    )]
    #[Assert\NotBlank(
        message: 'La spé est requis',
    )]
    private ?string $specialite = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'Le mail n\'est pas valide',
    )]
    #[Assert\NotBlank(
        message: 'Le mail est requis',
    )]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: "Le mail doit faire au moins {{ limit }} caractères",
        maxMessage: "Le mail ne doit pas faire plus que {{ limit }} caractères"
    )]
    private ?string $coordonnees = null;

    #[ORM\OneToMany(targetEntity: Assignation::class, mappedBy: 'docteur')]
    private Collection $assignations;

    public function __construct()
    {
        $this->assignations = new ArrayCollection();
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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getCoordonnees(): ?string
    {
        return $this->coordonnees;
    }

    public function setCoordonnees(string $coordonnees): static
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * @return Collection<int, Assignation>
     */
    public function getAssignations(): Collection
    {
        return $this->assignations;
    }

    public function addAssignation(Assignation $assignation): static
    {
        if (!$this->assignations->contains($assignation)) {
            $this->assignations->add($assignation);
            $assignation->setDocteur($this);
        }

        return $this;
    }

    public function removeAssignation(Assignation $assignation): static
    {
        if ($this->assignations->removeElement($assignation)) {
            // set the owning side to null (unless already changed)
            if ($assignation->getDocteur() === $this) {
                $assignation->setDocteur(null);
            }
        }

        return $this;
    }
}
