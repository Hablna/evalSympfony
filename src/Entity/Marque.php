<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'marque', cascade: ['persist', 'remove'])]
    private ?Collier $collier = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCollier(): ?Collier
    {
        return $this->collier;
    }

    public function setCollier(?Collier $collier): static
    {
        // unset the owning side of the relation if necessary
        if ($collier === null && $this->collier !== null) {
            $this->collier->setMarque(null);
        }

        // set the owning side of the relation if necessary
        if ($collier !== null && $collier->getMarque() !== $this) {
            $collier->setMarque($this);
        }

        $this->collier = $collier;

        return $this;
    }
}
