<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $course_name;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="course")
     */
    private $session;

    public function __construct()
    {
        $this->session = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseName(): ?string
    {
        return $this->course_name;
    }

    public function setCourseName(string $course_name): self
    {
        $this->course_name = $course_name;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session[] = $session;
            $session->setCourse($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->contains($session)) {
            $this->session->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getCourse() === $this) {
                $session->setCourse(null);
            }
        }

        return $this;
    }
}
