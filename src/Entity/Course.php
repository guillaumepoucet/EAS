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
     * @ORM\OneToMany(targetEntity=session::class, mappedBy="course")
     */
    private $course_session;

    public function __construct()
    {
        $this->course_session = new ArrayCollection();
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
     * @return Collection|session[]
     */
    public function getCourseSession(): Collection
    {
        return $this->course_session;
    }

    public function addCourseSession(session $courseSession): self
    {
        if (!$this->course_session->contains($courseSession)) {
            $this->course_session[] = $courseSession;
            $courseSession->setCourse($this);
        }

        return $this;
    }

    public function removeCourseSession(session $courseSession): self
    {
        if ($this->course_session->contains($courseSession)) {
            $this->course_session->removeElement($courseSession);
            // set the owning side to null (unless already changed)
            if ($courseSession->getCourse() === $this) {
                $courseSession->setCourse(null);
            }
        }

        return $this;
    }
}
