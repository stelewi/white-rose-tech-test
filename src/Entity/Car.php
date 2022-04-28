<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\UniqueConstraint(name: 'reg_unique_idx', columns: ['registration_number'])]
#[ApiResource]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private string $make;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private string $model;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\NotBlank]
    private string $registrationNumber;

    #[ORM\ManyToOne(targetEntity: Person::class, inversedBy: 'ownedCars')]
    #[ORM\JoinColumn(nullable: false)]
    private Person $owner;

    public function __construct(int $id, string $make, string $model, string $registrationNumber, Person $owner)
    {
        $this->id = $id;
        $this->make = $make;
        $this->model = $model;
        $this->registrationNumber = $registrationNumber;
        $this->owner = $owner;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMake(): string
    {
        return $this->make;
    }

    public function setMake(string $make): void
    {
        $this->make = $make;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function getOwner(): Person
    {
        return $this->owner;
    }

    public function setOwner(Person $owner): void
    {
        $this->owner = $owner;
    }
}
