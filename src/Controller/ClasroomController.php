<?php

namespace App\Controller;

use App\Entity\ClassRoom;
use App\Repository\ClassRoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ClassroomType;


class ClasroomController extends AbstractController
{
    #[Route('/clasroom', name: 'app_clasroom')]
    public function index(): Response
    {
        return $this->render('clasroom/index.html.twig', [
            'controller_name' => 'ClasroomController',
        ]);
    }
    #[Route('/listclasroom', name: 'list_clasroom')]
    public function listClasroom(ClassRoomRepository $repository)
    {
        $classroom = $repository->findAll();
        return $this->render('clasroom/listeclassroom.html.twig', array("tabclassroom" => $classroom));
    }
    #[Route('/addClassroom', name: 'add_Classroom')]
    public function addClassroom(ManagerRegistry $doctrine)
    {
        $classroom = new ClassRoom();
        $classroom->setname("3A29");
        $classroom->setDescription("Classe");
        $em = $doctrine->getManager();
        $em->persist($classroom);
        $em->flush();
        return $this->redirectToRoute("list_clasroom");
    }
    #[Route('/addForm', name: 'add2')]
    public function addForm(ManagerRegistry $doctrine, Request $request)
    {
        $classroom = new ClassRoom;
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return  $this->redirectToRoute("list_clasroom");
        }
        return $this->renderForm("clasroom/add.html.twig", array("formClassroom" => $form));
    }
    #[Route('/updateForm/{id}', name: 'update')]
    public function  updateForm($id, ClassRoomRepository $repository, ManagerRegistry $doctrine, Request $request)
    {
        $classroom = $repository->find($id);
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_clasroom");
        }
        return $this->renderForm("clasroom/update.html.twig", array("formClassroom" => $form));
    }
    #[Route('/removeForm/{id}', name: 'remove')]

    public function removeClassroom(ManagerRegistry $doctrine, $id, ClassRoomRepository $repository)
    {
        $classroom = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return  $this->redirectToRoute("list_clasroom");
    }
}
