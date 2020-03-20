<?php declare(strict_types=1);


namespace App\Student;

use DateTimeImmutable;
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
    private $birthdate;


    public static function fromDatabase(array $row): self
    {
        $student = new self();
        $student->id = (int) $row['id'];
        $student->lastname = $row['lastname'];
        $student->firstname = $row['firstname'];
        $student->birthdate = new DateTimeImmutable($row['birthdate']);

        return $student;
    }

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
     * @return \DateTimeImmutable
     */
    public function getBirthdate(): \DateTimeImmutable
    {
        return $this->birthdate;
    }

    /**
     * @param Date $birthDate
     */
    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = new \DateTimeImmutable($birthdate);
    }



}