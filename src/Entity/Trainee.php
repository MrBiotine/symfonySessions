<?php

namespace App\Entity;

use App\Repository\TraineeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraineeRepository::class)]
class Trainee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstNameTrainee = null;

    #[ORM\Column(length: 50)]
    private ?string $lastNameTrainee = null;

    #[ORM\Column(length: 255)]
    private ?string $emailTrainee = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $genderTrainee = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cityTrainee = null;

    #[ORM\Column(nullable: true)]
    private ?int $phoneTrainee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDateTrainee = null;

    #[ORM\ManyToMany(targetEntity: Session::class, inversedBy: 'trainees')]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstNameTrainee(): ?string
    {
        return $this->firstNameTrainee;
    }

    public function setFirstNameTrainee(string $firstNameTrainee): static
    {
        $this->firstNameTrainee = $firstNameTrainee;

        return $this;
    }

    public function getLastNameTrainee(): ?string
    {
        return $this->lastNameTrainee;
    }

    public function setLastNameTrainee(string $lastNameTrainee): static
    {
        $this->lastNameTrainee = $lastNameTrainee;

        return $this;
    }

    public function getEmailTrainee(): ?string
    {
        return $this->emailTrainee;
    }

    public function setEmailTrainee(string $emailTrainee): static
    {
        $this->emailTrainee = $emailTrainee;

        return $this;
    }

    public function getGenderTrainee(): ?string
    {
        return $this->genderTrainee;
    }

    public function setGenderTrainee(?string $genderTrainee): static
    {
        $this->genderTrainee = $genderTrainee;

        return $this;
    }

    public function getCityTrainee(): ?string
    {
        return $this->cityTrainee;
    }

    public function setCityTrainee(?string $cityTrainee): static
    {
        $this->cityTrainee = $cityTrainee;

        return $this;
    }

    public function getPhoneTrainee(): ?int
    {
        return $this->phoneTrainee;
    }

    public function setPhoneTrainee(?int $phoneTrainee): static
    {
        $this->phoneTrainee = $phoneTrainee;

        return $this;
    }

    public function getBirthDateTrainee(): ?\DateTimeInterface
    {
        return $this->birthDateTrainee;
    }

    public function setBirthDateTrainee(\DateTimeInterface $birthDateTrainee): static
    {
        $this->birthDateTrainee = $birthDateTrainee;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        $this->sessions->removeElement($session);

        return $this;
    }
}
