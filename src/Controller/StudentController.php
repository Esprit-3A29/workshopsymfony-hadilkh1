<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/listStudents', name: 'list_student')]
    public function listStudent(StudentRepository $repository)
    {
        $students = $repository->findAll();
        return $this->render("student/listStudent.html.twig", array("tabStudent" => $students));
    }
}
