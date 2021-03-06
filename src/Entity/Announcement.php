<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnouncementRepository::class)
 */
class Announcement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $announcement_title;

    /**
     * @ORM\Column(type="string", length=50000)
     */
    private $announcement_content;

    /**
     * @ORM\Column(type="date")
     */
    private $announcement_date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="announcements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_draft;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnouncementTitle(): ?string
    {
        return $this->announcement_title;
    }

    public function setAnnouncementTitle(?string $announcement_title): self
    {
        $this->announcement_title = $announcement_title;

        return $this;
    }

    public function getAnnouncementContent(): ?string
    {
        return $this->announcement_content;
    }

    public function setAnnouncementContent(string $announcement_content): self
    {
        $this->announcement_content = $announcement_content;

        return $this;
    }

    public function getAnnouncementDate(): ?\DateTimeInterface
    {
        return $this->announcement_date;
    }

    public function setAnnouncementDate(\DateTimeInterface $announcement_date): self
    {
        $this->announcement_date = $announcement_date;

        return $this;
    }
    
    public function getIsDraft(): ?bool
    {
        return $this->is_draft;
    }
    
    public function setIsDraft(bool $is_draft): self
    {
        $this->is_draft = $is_draft;
        
        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }
    
    public function setUser(?user $user): self
    {
        $this->user = $user;
    
        return $this;
    }
}
