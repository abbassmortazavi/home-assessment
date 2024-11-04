<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            security: "is_granted('ROLE_SUPER_ADMIN')",
            securityMessage: "Only SUPER ADMIN can create companies."
        ),
    ]
)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'company')]
    private Collection $userRelatedCompany;

    public function __construct()
    {
        $this->userRelatedCompany = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserRelatedCompany(): Collection
    {
        return $this->userRelatedCompany;
    }

    public function addUserRelatedCompany(User $userRelatedCompany): static
    {
        if (!$this->userRelatedCompany->contains($userRelatedCompany)) {
            $this->userRelatedCompany->add($userRelatedCompany);
            $userRelatedCompany->setCompany($this);
        }

        return $this;
    }

    public function removeUserRelatedCompany(User $userRelatedCompany): static
    {
        if ($this->userRelatedCompany->removeElement($userRelatedCompany)) {
            // set the owning side to null (unless already changed)
            if ($userRelatedCompany->getCompany() === $this) {
                $userRelatedCompany->setCompany(null);
            }
        }

        return $this;
    }

}
