<?php declare(strict_types=1);


namespace App\Student\Controller;


use App\Infrastructure\Exception\InvalidData;
use App\Infrastructure\Exception\NotFound;
use App\Student\Grade;
use App\Student\Student;
use App\Student\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/** @Route("/api", name="api_") */

class StudentController extends AbstractController
{
    /** @var StudentService */
    private $studentService;

    /** @var Serializer\ */
    private $serializer;

    /** @var ValidatorInterface  */
    private $validator;

    public function __construct(StudentService $studentService,ValidatorInterface $validator)
    {
        $this->studentService = $studentService;
        $this->serializer = new Serializer([new ObjectNormalizer()],[new JsonEncoder()]);
        $this->validator = $validator;
    }

    /**
     * @Route("/student/add", methods={"POST"})
     */
    public function  addStudent(Request $request)
    {
        try
        {
            $payload = $request->getContent();
            $student = $this->serializer->deserialize($payload,Student::class,'json');
            $this->studentService->validate($student);
            $id = $this->studentService->create($student);
            return new JsonResponse(["status" => "success","message"=> "student was created with $id"]);
        }
        catch (InvalidData  $e)
        {
            return new JsonResponse(["status" => "error","message"=> $e->getMessage()]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["status" => "success","message"=> $e->getMessage()]);
        }



    }

    /**
     * @Route("/student/{id}", methods={"PUT"}, requirements={"id"="\d+"})
     */
    public function updateStudent(int $id, Request $request)
    {
        try
        {
        $payload = $request->getContent();
        $student = $this->serializer->deserialize($payload,Student::class,'json');
        $this->validator->validate($student);
        $this->studentService->update($student);
        return new JsonResponse(["status" => "success","message"=> "user $id was updated"]);
        }
        catch (InvalidData  $e)
        {
            return new JsonResponse(["status" => "error","message"=> $e->getMessage()]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["status" => "success","message"=> $e->getMessage()]);
        }
    }

    /**
     * @Route("/student/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteStudent(int $id, Request $request)
    {
        try{
            $this->studentService->delete($id);
        }
        catch (NotFound $e)
        {
            return new JsonResponse(["status" => "error","message"=> "user $id was not found"]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["status" => "error","message"=> "an error occured during the process please try later"]);
        }

        return new JsonResponse(["status" => "success","message"=> "account $id was deleted"]);
    }

    /**
     * @Route("/student/{id}/grade/add", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function addGrade(int $id, Request $request)
    {
        try
        {
            $payload = $request->getContent();
            $grade = $this->serializer->deserialize($payload,Grade::class,'json');
            $this->studentService->validate($grade);
            $id = $this->studentService->addGradeToStudent($grade,$id);
            return new JsonResponse(["status" => "success","message"=> "student was created with $id"]);
        }
        catch (InvalidData  $e)
        {
            return new JsonResponse(["status" => "error","message"=> $e->getMessage()]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["status" => "success","message"=> $e->getMessage()]);
        }
    }

    /**
     * @Route("student/{id}/grade/avg", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getStudentAverage(int $id, Request $request)
    {
        try
        {
            $this->studentService->getStudentGradeAverage($id);
        }
        catch (NotFound $e)
        {
            return new JsonResponse(["status" => "error","message"=> "user $id was not found"]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["status" => "error","message"=> "an error occured during the process please try later"]);
        }

    }
    /**
     * @Route("/grade/avg", methods={"GET"})
     */
    public function getGradesAverage(Request $request)
    {
        try
        {
            $this->studentService->getStudentGradeAverage($id);
        }
        catch (NotFound $e)
        {
            return new JsonResponse(["status" => "error","message"=> "user $id was not found"]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["status" => "error","message"=> "an error occured during the process please try later"]);
        }
    }
}