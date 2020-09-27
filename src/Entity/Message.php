<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35000)
     */
    private $message_content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $message_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_reported;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $read_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesSent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesReceived")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageContent(): ?string
    {
        return $this->message_content;
    }

    public function setMessageContent(string $message_content): self
    {
        $this->message_content = $message_content;

        return $this;
    }

    public function getMessageDate(): ?\DateTimeInterface
    {
        return $this->message_date;
    }

    public function setMessageDate(\DateTimeInterface $message_date): self
    {
        $this->message_date = $message_date;

        return $this;
    }

    public function getIsReported(): ?bool
    {
        return $this->is_reported;
    }

    public function setIsReported(bool $is_reported): self
    {
        $this->is_reported = $is_reported;

        return $this;
    }

    public function getReadAt(): ?\DateTimeInterface
    {
        return $this->read_at;
    }

    public function setReadAt(?\DateTimeInterface $read_at): self
    {
        $this->read_at = $read_at;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}
