<?php declare(strict_types=1);


namespace App\Student;

use App\Infrastructure\Exception\InvalidData;
use App\Infrastructure\Exception\NotFound;
use Doctrine\DBAL\Connection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StudentService
{
    /** @var Connection */
    private $db;

    /** @var ValidatorInterface  */
    private $validator;

    /**
     * StudentService constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db,ValidatorInterface $validator)
    {
        $this->db = $db;
        $this->validator = $validator;
    }


    public function find(int $id): Student
    {
        $row = $this->db->fetchAssoc('SELECT * FROM `student` WHERE id = ?', [$id]);
        if (!$row) {
            throw NotFound::fromEntity(student::class, $id);
        }

        return Student::fromDatabase($row);
    }

    public  function create(Student $student): int
    {
        $this->db->insert('student', [
            'firstname'=> $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'birthdate' => $student->getBirthDate()
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(Student $student): void
    {
        $this->find($student->getId());
        $this->db->update('student', [
            'firstname'=> $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'birthdate' => $student->getBirthDate()
        ], [
            'id' => $student->getId(),
        ]);
    }

    public function delete(int $id): void
    {
        $this->find($id);
        $this->db->delete('student',[$id]);
    }

    public  function addGradeToStudent(Grade $grade , int $id)
    {
        $this->find($id);
        $this->db->insert('grade', [
            'student_id'=> $id,
            'grade' => $grade->getGrade(),
            'subject' => $grade->getSubject()
        ]);
    }

    public function getStudentGradeAverage(int $id)
    {
        $this->find($id);
        $row = $this->db->fetchAssoc('SELECT AVG(grades) FROM `grades` WHERE student_id = ?', [$id]);
    }

    public function getGradeAverage()
    {
        $row = $this->db->fetchAssoc('SELECT AVG(grades) FROM `grades`');
    }

    public function validate(Student $student): void
    {
        $errors = $this->validator->validate($student);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new InvalidData($errorsString);

        }
    }


}