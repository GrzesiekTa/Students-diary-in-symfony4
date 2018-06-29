<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\Student1Type;
use App\Repository\DiaryRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student")
 */
class StudentController extends Controller
{
    /**
     * @Route("/", name="student_index", methods="GET")
     */
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('student/index.html.twig', ['students' => $studentRepository->findAll()]);
    }

    /**
     * @Route("/new", name="student_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(Student1Type::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_edit", methods="GET|POST")
     */
    public function edit(Request $request, Student $student): Response
    {
        $form = $this->createForm(Student1Type::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_edit', ['id' => $student->getId()]);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_delete", methods="DELETE")
     */
    public function delete($id, Request $request, Student $student, DiaryRepository $diaryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $student->getId(), $request->request->get('_token'))) {

            $em = $this->getDoctrine()->getManager();

            $removeDiary = $diaryRepository->findBy(array('student' => $id));

            foreach ($removeDiary as $rd) {
                $em->remove($rd);
            }

            $em->remove($student);
            $em->flush();
        }

        return $this->redirectToRoute('student_index');
    }
}
