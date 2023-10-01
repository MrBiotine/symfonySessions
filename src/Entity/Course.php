<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nameCourse = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Programm::class)]
    private Collection $programms;

    public function __construct()
    {
        $this->programms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCourse(): ?string
    {
        return $this->nameCourse;
    }

    public function setNameCourse(?string $nameCourse): static
    {
        $this->nameCourse = $nameCourse;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $programm->setCourse($this);
        }

        return $this;
    }

    public function removeProgramm(Programm $programm): static
    {
        if ($this->programms->removeElement($programm)) {
            // set the owning side to null (unless already changed)
            if ($programm->getCourse() === $this) {
                $programm->setCourse(null);
            }
        }

        return $this;
    }
}
