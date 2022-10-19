<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/addstudent', name: 'add_student')]
    public function add(StudentRepository $repository, Request $request)
    {
        $student = new Student;
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $repository->add($student, True);
            // return  $this->redirectToRoute("list_student");
        }

        return $this->renderForm("student/addstudent.html.twig", array("StudentForm" => $form));
    }
}
