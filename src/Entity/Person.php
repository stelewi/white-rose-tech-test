<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ApiResource]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private string $lastName;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Date]
    private ?string $dateOfBirth;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Car::class, orphanRemoval: true)]
    private Collection $ownedCars;

//    #[ORM\Column(type: 'datetime')]
//    /**
//     * @Gedmo\Timestampable(on="create")
//     */
//    private \DateTime $createdAt;
//
//
//    #[ORM\Column(type: 'datetime')]
//    /**
//     * @Gedmo\Timestampable(on="update")
//     */
//    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->ownedCars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getAge(): ?int
    {
        if(is_null($this->dateOfBirth))
        {
            return null;
        }

        return \DateTimeImmutable::createFromFormat('Y-m-d', $this->dateOfBirth)
            ->diff(new \DateTimeImmutable('now'))->y;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getOwnedCars(): Collection
    {
        return $this->ownedCars;
    }

    public function addOwnedCar(Car $ownedCar): self
    {
        if (!$this->ownedCars->contains($ownedCar)) {
            $this->ownedCars[] = $ownedCar;
            $ownedCar->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedCar(Car $ownedCar): self
    {
        if ($this->ownedCars->removeElement($ownedCar)) {
            // set the owning side to null (unless already changed)
            if ($ownedCar->getOwner() === $this) {
                $ownedCar->setOwner(null);
            }
        }

        return $this;
    }
}
