<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\Translation\t;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    private ?User $visitor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

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

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getVisitor(): ?User
    {
        return $this->visitor;
    }

    public function setVisitor(?User $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

}
