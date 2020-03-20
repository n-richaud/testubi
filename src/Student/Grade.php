<?php declare(strict_types=1);

namespace App\Student;

use Symfony\Component\Validator\Constraints as Assert;

class Grade{

    /** @var int */
    private $id;

    /** @var int */
    private $studentId;

    /** @var string */
    private $subject;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      minMessage = "Grade must be between 0 ad",
     *      maxMessage = "You cannot be taller than {{ limit }}cm to enter"
     * )
     */
    private $grade;

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
     * @return int
     */
    public function getStudentId(): int
    {
        return $this->studentId;
    }

    /**
     * @param int $studentId
     */
    public function setStudentId(int $studentId): void
    {
        $this->studentId = $studentId;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return int
     */
    public function getGrade(): int
    {
        return $this->grade;
    }

    /**
     * @param int $grade
     */
    public function setGrade(int $grade): void
    {
        $this->grade = $grade;
    }


}