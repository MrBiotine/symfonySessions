<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nameTraining = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionTraining = null;

    #[ORM\OneToMany(mappedBy: 'training', targetEntity: Session::class)]
    private Collection $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTraining(): ?string
    {
        return $this->nameTraining;
    }

    public function setNameTraining(string $nameTraining): static
    {
        $this->nameTraining = $nameTraining;

        return $this;
    }

    public function getDescriptionTraining(): ?string
    {
        return $this->descriptionTraining;
    }

    public function setDescriptionTraining(?string $descriptionTraining): static
    {
        $this->descriptionTraining = $descriptionTraining;

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
            $session->setTraining($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getTraining() === $this) {
                $session->setTraining(null);
            }
        }

        return $this;
    }
}
