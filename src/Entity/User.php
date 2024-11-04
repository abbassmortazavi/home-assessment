<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Enums\UserRole;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(

    operations: [
        // GET /users (collection) - Available to all roles
        new GetCollection(
            security: "is_granted('ROLE_USER')",
            securityMessage: "You do not have access to view users."
        ),

        // GET /users/{id} (item) - Available to all roles
        new Get(
            security: "is_granted('ROLE_USER')",
            securityMessage: "You do not have access to view this user."
        ),

        // POST /users - Available to SUPERADMIN and COMPANY ADMIN only
        new Post(
            security: "is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_COMPANY_ADMIN')",
            securityMessage: "Only SUPER ADMIN and COMPANY ADMIN can create users.",
        ),

        // DELETE /users/{id} - Available to SUPERADMIN only
        new Delete(
            security: "is_granted('ROLE_SUPER_ADMIN')",
            securityMessage: "Only SUPER ADMIN can delete users."
        )

    ]
)]
#[ORM\Table(name: '`user`')]
class User implements \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    private ?string $email = null;
    #[ORM\Column(length: 250)]
    #[Assert\NotBlank(message: "Name is required.")]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: "Name must be at least {{ limit }} characters long.",
        maxMessage: "Name cannot be longer than {{ limit }} characters."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-z\s]+$/",
        message: "Name can only contain letters and spaces."
    )]
    #[Assert\Regex(
        pattern: "/[A-Z]/",
        message: "Name must contain at least one uppercase letter.",
        match: true
    )]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, enumType: UserRole::class)]
    #[Assert\Type(type: UserRole::class, message: 'Invalid role')]
    private UserRole $role = UserRole::ROLE_USER;

    #[ORM\ManyToOne(inversedBy: 'userRelatedCompany')]
    private ?Company $company = null;

    #[ORM\Column(type: 'text')]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $username = null;

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function setUsername(string $username): self
    {
        $this->username = $this->email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    #[Callback]
    public function validateCompanyRequirement(ExecutionContextInterface $context): void
    {
        if ($this->role === UserRole::ROLE_SUPER_ADMIN) {
            $context->buildViolation('The SUPER ADMIN role cannot have a company.')
                ->atPath('company')
                ->addViolation();
        }
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getRole(): UserRole
    {
        return $this->role;
    }

    /**
     * @param UserRole $role
     * @return $this
     */
    public function setRole(UserRole $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        $roles[] = $this->role->value;
        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
