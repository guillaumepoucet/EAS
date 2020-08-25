<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Session;
use App\Form\AddCourseType;
use App\Form\AddSessionType;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSessionsController extends AbstractController
{
    /**
     * @Route("/admin/sessions", name="sessions.management")
     */
    public function index(Request $request, CourseRepository $courseRepo, SessionRepository $sessionRepo)
    {
        // retrieve courses info
        $courses = $courseRepo->findAll();

        // retrieve sessions info
        $sessions = $sessionRepo->findAll();

        // creating form to add courses
        $newCourse = new Course;

        $courseForm = $this->createForm(AddCourseType::class, $newCourse);

        $courseForm->handleRequest($request);
        if ($courseForm->isSubmitted() && $courseForm->isValid()) {
            $newCourse = $courseForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newCourse);
            $entityManager->flush();

            return $this->redirectToRoute('sessions.management');
        }

        // creating form to add course sessions
        $newSession = new Session;

        $sessionForm = $this->createForm(AddSessionType::class, $newSession);

        $sessionForm->handleRequest($request);
        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            $newSession = $sessionForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newSession);
            $entityManager->flush();

            return $this->redirectToRoute('sessions.management');
        }

        return $this->render('admin/sessions_management/index.html.twig', [
            'controller_name' => 'AdminSessionsController',
            'courses' => $courses,
            'sessions' => $sessions,
            'courseForm' => $courseForm->createView(),
            'sessionForm' => $sessionForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete/course/{id}", name="delete.course")
     */

    public function deleteCourse(CourseRepository $courseRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $course = $courseRepo->find($id);
        $entityManager->remove($course);
        $entityManager->flush();
        return $this->redirectToRoute('sessions.management');
    }

    /**
     * @Route("/admin/delete/session/{id}", name="delete.session")
     */

    public function deleteSession(SessionRepository $sessionRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $sessionRepo->find($id);
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('sessions.management');
    }

    /**
     * @Route("/admin/session/edit/{id}", name="edit.session")
     */

    public function editSession(Session $session, Request $request)
    {
        $sessionForm = $this->createForm(AddSessionType::class, $session);

        $sessionForm->handleRequest($request);
        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            $Session = $sessionForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('sessions.management');
        }

        return $this->render('admin/sessions_management/editSession.html.twig', [
            'controller_name' => 'AdminSessionsController',
            'session' => $session,
            'sessionForm' => $sessionForm->createView(),
        ]);
    }
}
