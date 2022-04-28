<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ApiResource]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 50)]
    private $lastName;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateOfBirth;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Car::class, orphanRemoval: true)]
    private $ownedCars;

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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
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
