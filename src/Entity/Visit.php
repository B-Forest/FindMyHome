<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $promoteur = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'visits')]
    private Collection $visitor;

    public function __construct()
    {
        $this->visitor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getPromoteur(): ?User
    {
        return $this->promoteur;
    }

    public function setPromoteur(?User $promoteur): self
    {
        $this->promoteur = $promoteur;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getVisitor(): Collection
    {
        return $this->visitor;
    }

    public function addVisitor(User $visitor): self
    {
        if (!$this->visitor->contains($visitor)) {
            $this->visitor->add($visitor);
        }

        return $this;
    }

    public function removeVisitor(User $visitor): self
    {
        $this->visitor->removeElement($visitor);

        return $this;
    }
}
