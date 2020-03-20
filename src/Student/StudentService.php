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


    /**
     * @param int $id
     * @return Student
     * @throws \Doctrine\DBAL\DBALException
     */
    public function find(int $id): Student
    {
        $row = $this->db->fetchAssoc('SELECT * FROM `student` WHERE id = ?', [$id]);
        if (!$row) {
            throw NotFound::fromEntity(student::class, $id);
        }

        return Student::fromDatabase($row);
    }

    /**
     * @param Student $student
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public  function create(Student $student): int
    {
        $this->db->insert('student', [
            'firstname'=> $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'birthdate' => $student->getBirthDate()->format('Y/m/d H:i:s')
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * @param Student $student
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update(Student $student): void
    {
        $this->find($student->getId());
        $this->db->update('student', [
            'firstname'=> $student->getFirstname(),
            'lastname' => $student->getLastname(),
            'birthdate' => $student->getBirthDate()->format('Y/m/d H:i:s')
        ], [
            'id' => $student->getId(),
        ]);
    }

    /**
     * @param int $id
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete(int $id): void
    {
        $this->find($id);
        dd($id);
        $this->db->delete('student',[$id]);
    }

    /**
     * @param Grade $grade
     * @param int $id
     * @throws \Doctrine\DBAL\DBALException
     */
    public  function addGradeToStudent(Grade $grade , int $id)
    {
        $this->find($id);
        $this->db->insert('grade', [
            'student_id'=> $id,
            'grade' => $grade->getGrade(),
            'subject' => $grade->getSubject()
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getStudentGradeAverage(int $id)
    {
        $this->find($id);
        $row = $this->db->fetchAssoc('SELECT AVG(grade) as average FROM `grade` WHERE student_id = ?', [$id]);
        return $row['average'];
    }

    /**
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getGradeAverage()
    {
        $row = $this->db->fetchAssoc('SELECT AVG(grade) as average FROM `grade`');
        return $row['average'];
    }

    /**
     * @param $student
     * @throws InvalidData
     */
    public function validate($student): void
    {
        $errors = $this->validator->validate($student);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            throw new InvalidData($errorsString);

        }
    }



}