<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity() */
class Person
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;
    /** @ORM\Column */
    private string $passportId;
    /** @ORM\Column */
    private DateTime $passportExpirDate;
    /** @ORM\Column */
    private DateTime $passportDateOfBirth;
    /** @ORM\Column */
    private DateTime $passportEndDate;
    /** @ORM\Column */
    private string $name;
    /** @ORM\Column */
    private string $lastname;
    /** @ORM\Column(nullable=true) */
    private ?string $generatedValue = null;

    public function __construct(
        string $passportId,
        DateTime $passportDateOfIssue,
        DateTime $passportDateOfBirth,
        DateTime $passportEndDate,
        string $name,
        string $surname,
        ?string $generatedValue = null
    ) {
        $this->passportId = $passportId;
        $this->passportExpirDate = $passportDateOfIssue;
        $this->passportDateOfBirth = $passportDateOfBirth;
        $this->passportEndDate = $passportEndDate;
        $this->name = $name;
        $this->lastname = $surname;
        $this->generatedValue = $generatedValue;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassportId(): string
    {
        return $this->passportId;
    }

    /**
     * @return DateTime
     */
    public function getPassportExpirDate(): DateTime
    {
        return $this->passportExpirDate;
    }

    /**
     * @return DateTime
     */
    public function getPassportDateOfBirth(): DateTime
    {
        return $this->passportDateOfBirth;
    }

    /**
     * @return DateTime
     */
    public function getPassportEndDate(): DateTime
    {
        return $this->passportEndDate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string|null
     */
    public function getGeneratedValue(): ?string
    {
        return $this->generatedValue;
    }

    /**
     * @param string|null $generatedValue
     */
    public function setGeneratedValue(?string $generatedValue): void
    {
        $this->generatedValue = $generatedValue;
    }
}