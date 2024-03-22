<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AssignationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignationRepository::class)]
#[ApiResource]
class Assignation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    private ?Medecin $docteur = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    private ?Chambre $chambre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_assignation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_sortie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocteur(): ?Medecin
    {
        return $this->docteur;
    }

    public function setDocteur(?Medecin $docteur): static
    {
        $this->docteur = $docteur;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): static
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getDateAssignation(): ?\DateTimeInterface
    {
        return $this->date_assignation;
    }

    public function setDateAssignation(\DateTimeInterface $date_assignation): static
    {
        $this->date_assignation = $date_assignation;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(?\DateTimeInterface $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }
}
