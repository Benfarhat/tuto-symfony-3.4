<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Votre titre doit avoir au moins {{ limit }} characteres",
     *      maxMessage = "Votre titre doit avoir au plus {{ limit }} characteres"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le contenu de votre article est trop court, il doit avoir au moins {{ limit }} characteres"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)     
     * @Assert\Url(
     *    message = "L'URL de votre image '{{ value }}' n'est pas valide",
     *    checkDNS = "ANY",
     *    dnsMessage = "Le Host '{{ value }}' n'a pu être résolu au niveau DNS (indisponible)."
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
