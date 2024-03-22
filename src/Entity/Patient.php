<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ApiResource]
#[UniqueEntity('nom')]
#[ApiFilter(SearchFilter::class, properties: ['age' => 'exact', 'diagnostic' => 'partial'])]
class Patient
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

    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'L\'age est requis',
    )]
    #[Assert\Length(
        min: 1,
        max: 3,
        minMessage: "L'age doit faire au moins {{ limit }} caractères",
        maxMessage: "L'age ne doit pas faire plus que {{ limit }} caractères"
    )]
    private ?int $age = null;

    #[ORM\Column(length: 40)]
    #[Assert\Choice(
        ['homme', 'femme',"autre"],
        message: 'Genre est invalide'
    )]
    #[Assert\NotBlank(
        message: 'Le genre est requis',
    )]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 20,
        max: 255,
        minMessage: "Le diagnostic doit faire au moins {{ limit }} caractères",
        maxMessage: "Le diagnostic ne doit pas faire plus que {{ limit }} caractères"
    )]
    #[Assert\NotBlank(
        message: 'Le diagnostic est requis',
    )]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: "Le mail doit faire au moins {{ limit }} caractères",
        maxMessage: "Le mail ne doit pas faire plus que {{ limit }} caractères"
    )]
    #[Assert\Email(
        message: 'Le mail n\'est pas valide',
    )]
    #[Assert\NotBlank(
        message: 'Le mail est requis',
    )]
    private ?string $coordonnees = null;

    #[ORM\OneToMany(targetEntity: Assignation::class, mappedBy: 'patient')]
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(string $diagnostic): static
    {
        $this->diagnostic = $diagnostic;

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
            $assignation->setPatient($this);
        }

        return $this;
    }

    public function removeAssignation(Assignation $assignation): static
    {
        if ($this->assignations->removeElement($assignation)) {
            // set the owning side to null (unless already changed)
            if ($assignation->getPatient() === $this) {
                $assignation->setPatient(null);
            }
        }

        return $this;
    }
}
