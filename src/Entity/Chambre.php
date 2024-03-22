<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
#[ApiResource]
#[UniqueEntity('nom')]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Le num de chambre est requis',
    )]
    #[Assert\Length(
        min: 1,
        max: 10,
        minMessage: "Le num de chambre doit faire au moins {{ limit }} caractères",
        maxMessage: "Le num de chambre ne doit pas faire plus que {{ limit }} caractères"
    )]
    private ?int $numChambre = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 20,
        max: 255,
        minMessage: "Le type doit faire au moins {{ limit }} caractères",
        maxMessage: "Le type ne doit pas faire plus que {{ limit }} caractères"
    )]
    #[Assert\NotBlank(
        message: 'Le type est requis',
    )]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 20,
        max: 255,
        minMessage: "Le status doit faire au moins {{ limit }} caractères",
        maxMessage: "Le status ne doit pas faire plus que {{ limit }} caractères"
    )]
    #[Assert\NotBlank(
        message: 'Le status est requis',
    )]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Assignation::class, mappedBy: 'chambre')]
    private Collection $assignations;

    public function __construct()
    {
        $this->assignations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumChambre(): ?int
    {
        return $this->numChambre;
    }

    public function setNumChambre(int $numChambre): static
    {
        $this->numChambre = $numChambre;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
            $assignation->setChambre($this);
        }

        return $this;
    }

    public function removeAssignation(Assignation $assignation): static
    {
        if ($this->assignations->removeElement($assignation)) {
            // set the owning side to null (unless already changed)
            if ($assignation->getChambre() === $this) {
                $assignation->setChambre(null);
            }
        }

        return $this;
    }
}
