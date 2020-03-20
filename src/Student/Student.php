<?php declare(strict_types=1);


namespace App\Student;

use Symfony\Component\Validator\Constraints as Assert;
use App\Student\Grade;

class Student
{
    /** @var int */
    private $id ;

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    /** @var DateTimeImmutable *
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     */
    private $birthDate;

    /** @var Grade */
    private $grades;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {

        $this->lastname = $lastname;
    }

    /**
     * @return Date
     */
    public function getBirthDate(): Date
    {
        return $this->birtDate;
    }

    /**
     * @param Date $birthDate
     */
    public function setBirthDate(string $birtDate): void
    {

        $this->birthDate = new \DateTimeImmutable($birtDate);
    }

    /**
     * @return \App\Student\Grade
     */
    public function getGrades(): \App\Student\Grade
    {
        return $this->grades;
    }

    /**
     * @param \App\Student\Grade $grades
     */
    public function setGrades(\App\Student\Grade $grades): void
    {
        $this->grades = $grades;
    }



}