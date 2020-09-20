<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Course;
use App\Entity\Session;
use App\Form\AddCourseType;
use App\Form\AddSessionType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 /**
     * @Route("/admin/sessions", name="sessions_")
     */
class AdminSessionsController extends AbstractController
{
    /**
     * @Route("", name="management")
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

            $this->addFlash('success', 'Nouveau module créé');

            return $this->redirectToRoute('sessions_management');
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

            $this->addFlash('success', 'Nouvelle session créée');

            return $this->redirectToRoute('sessions_management');
        }

        return $this->render('sessions_management/index.html.twig', [
            'controller_name' => 'AdminSessionsController',
            'courses' => $courses,
            'sessions' => $sessions,
            'courseForm' => $courseForm->createView(),
            'sessionForm' => $sessionForm->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */

    public function editSession(Session $session, Request $request, UserRepository $userRepo, SessionRepository $sessionRepo)
    {
        // retrieve users info
        $users = $userRepo->findAll();

        // retrieve sessions info
        $sessions = $sessionRepo->findAll();

        foreach ($users as $user) {
            $userId = $user->getId();
            $sessions = $userRepo->find($userId)->getSessions();
            foreach ($sessions as $s) {
                $sessionId = $s->getId();
            }
        }

        $sessionForm = $this->createForm(AddSessionType::class, $session);

        $sessionForm->handleRequest($request);
        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            $Session = $sessionForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('edit', 'Session éditée');

            return $this->redirectToRoute('sessions_management');
        }

        return $this->render('sessions_management/editSession.html.twig', [
            'controller_name' => 'AdminSessionsController',
            'session' => $session,
            'sessions' => $sessions,
            'users' => $users,
            'sessionForm' => $sessionForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function deleteSession(SessionRepository $sessionRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $sessionRepo->find($id);
        $entityManager->remove($session);
        $entityManager->flush();

        $this->addFlash('delete', 'Session supprimée');

        return $this->redirectToRoute('sessions_management');
    }
    
    /**
     * @Route("/{session}/add/{user}", name="add_user")
     */

    public function addUserToSession(User $user, Session $session)
    {
        $session->addUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $this->addFlash('success', 'Elève ajouté à la session');

        return $this->redirectToRoute('sessions_edit', [
            'id' => $session->getId()
        ]);
    }

    /**
     * @Route("/{session}/remove/{user}", name="remove_user")
     */

    public function removeUserOfSession(User $user, Session $session)
    {
        $session->removeUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $this->addFlash('delete', 'Elève supprimé à la session');

        return $this->redirectToRoute('sessions_edit', [
            'id' => $session->getId()
        ]);
    }
}
