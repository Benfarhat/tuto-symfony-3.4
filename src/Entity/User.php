<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Votre pseudonyme est trop court, veuillez en choisir un supérieur à {{ limit }} characteres"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le mot de passe doit avoir au moins {{ limit }} characteres"
     * )
     * @Assert\EqualTo(
     *     propertyPath = "confirm_password",
     *     message = "Le mot de passe ne correspond pas à sa confirmation"
     * )
     */
    private $password;

    /**
     * @Assert\EqualTo(
     *     propertyPath = "confirm_password",
     *     message = "Le mot de passe de confirmation ne correspond pas à celui précédemment fourni"
     * )
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
