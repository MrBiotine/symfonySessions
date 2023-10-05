<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateBeginSession = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEndSession = null;

    #[ORM\Column]
    private ?int $nbMaxSession = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Training $training = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Trainer $trainer = null;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Programm::class, cascade: ["persist"], orphanRemoval: true )]
    private Collection $programms;

    #[ORM\ManyToMany(targetEntity: Trainee::class, mappedBy: 'sessions')]
    private Collection $trainees;

    public function __construct()
    {
        $this->programms = new ArrayCollection();
        $this->trainees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBeginSession(): ?\DateTimeInterface
    {
        return $this->dateBeginSession;
    }

    public function setDateBeginSession(\DateTimeInterface $dateBeginSession): static
    {
        $this->dateBeginSession = $dateBeginSession;

        return $this;
    }

    public function getDateEndSession(): ?\DateTimeInterface
    {
        return $this->dateEndSession;
    }

    public function setDateEndSession(\DateTimeInterface $dateEndSession): static
    {
        $this->dateEndSession = $dateEndSession;

        return $this;
    }

    public function getNbMaxSession(): ?int
    {
        return $this->nbMaxSession;
    }

    public function setNbMaxSession(int $nbMaxSession): static
    {
        $this->nbMaxSession = $nbMaxSession;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): static
    {
        $this->training = $training;

        return $this;
    }

    public function getTrainer(): ?Trainer
    {
        return $this->trainer;
    }

    public function setTrainer(?Trainer $trainer): static
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * @return Collection<int, Programm>
     */
    public function getProgramms(): Collection
    {
        return $this->programms;
    }

    public function addProgramm(Programm $programm): static
    {
        if (!$this->programms->contains($programm)) {
            $this->programms->add($programm);
            $programm->setSession($this);
        }

        return $this;
    }

    public function removeProgramm(Programm $programm): static
    {
        if ($this->programms->removeElement($programm)) {
            // set the owning side to null (unless already changed)
            if ($programm->getSession() === $this) {
                $programm->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trainee>
     */
    public function getTrainees(): Collection
    {
        return $this->trainees;
    }

    public function addTrainee(Trainee $trainee): static
    {
        if (!$this->trainees->contains($trainee)) {
            $this->trainees->add($trainee);
            $trainee->addSession($this);
        }

        return $this;
    }

    public function removeTrainee(Trainee $trainee): static
    {
        if ($this->trainees->removeElement($trainee)) {
            $trainee->removeSession($this);
        }

        return $this;
    }

    public function __toString(){
       return $this->getTraining()->getNameTraining();
    }
    //to count the number of registered trainees
    public function getNbRegistered(): ?int
    {
        return count($this->trainees);                                        // count() pour compter le nombre de places restantes dans la collection stagiaires de l'entité Session.php
    }
}
