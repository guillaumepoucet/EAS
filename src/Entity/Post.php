<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $post_title;

    /**
     * @ORM\Column(type="string", length=50000, nullable=true)
     */
    private $post_content;

    /**
     * @ORM\Column(type="date")
     */
    private $post_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_visible;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $post_cover;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_archived;

    /**
     * @ORM\OneToMany(targetEntity=image::class, mappedBy="post")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostTitle(): ?string
    {
        return $this->post_title;
    }

    public function setPostTitle(string $post_title): self
    {
        $this->post_title = $post_title;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->post_content;
    }

    public function setPostContent(?string $post_content): self
    {
        $this->post_content = $post_content;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->post_date;
    }

    public function setPostDate(\DateTimeInterface $post_date): self
    {
        $this->post_date = $post_date;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $is_visible): self
    {
        $this->is_visible = $is_visible;

        return $this;
    }

    public function getPostCover(): ?string
    {
        return $this->post_cover;
    }

    public function setPostCover(?string $post_cover): self
    {
        $this->post_cover = $post_cover;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->is_archived;
    }

    public function setIsArchived(?bool $is_archived): self
    {
        $this->is_archived = $is_archived;

        return $this;
    }

    /**
     * @return Collection|image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setPost($this);
        }

        return $this;
    }

    public function removeImage(image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPost() === $this) {
                $image->setPost(null);
            }
        }

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
