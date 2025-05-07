<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\RoleType;
use App\Repository\SubscriptionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription  //extends ServiceEntityRepository
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'First name cannot be blank')]
    private string $firstName;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: 'Last name cannot be blank')]
    private string $lastName;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank(message: 'Email cannot be blank')]
    #[Assert\Email(message: 'Invalid email format')]
    private string $email;

    #[ORM\Column(type: 'string', enumType: RoleType::class)]
    #[Assert\NotBlank(message: 'Role cannot be blank')]
    #[Assert\Choice(choices: ['student', 'teacher', 'parent', 'tutor'], message: 'Invalid role type')]
    private RoleType $role;


    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getRole(): RoleType
    {
        return $this->role;
    }

    public function setRole(RoleType $role): self
    {
        $this->role = $role;
        return $this;
    }
}