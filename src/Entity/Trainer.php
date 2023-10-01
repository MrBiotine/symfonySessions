<?php

namespace App\Entity;

use App\Repository\TrainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainerRepository::class)]
class Trainer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstNameTrainer = null;

    #[ORM\Column(length: 50)]
    private ?string $lastNameTrainer = null;

    #[ORM\Column(length: 255)]
    private ?string $emailTrainer = null;

    #[ORM\OneToMany(mappedBy: 'trainer', targetEntity: Session::class)]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstNameTrainer(): ?string
    {
        return $this->firstNameTrainer;
    }

    public function setFirstNameTrainer(string $firstNameTrainer): static
    {
        $this->firstNameTrainer = $firstNameTrainer;

        return $this;
    }

    public function getLastNameTrainer(): ?string
    {
        return $this->lastNameTrainer;
    }

    public function setLastNameTrainer(string $lastNameTrainer): static
    {
        $this->lastNameTrainer = $lastNameTrainer;

        return $this;
    }

    public function getEmailTrainer(): ?string
    {
        return $this->emailTrainer;
    }

    public function setEmailTrainer(string $emailTrainer): static
    {
        $this->emailTrainer = $emailTrainer;

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
            $session->setTrainer($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getTrainer() === $this) {
                $session->setTrainer(null);
            }
        }

        return $this;
    }
}
