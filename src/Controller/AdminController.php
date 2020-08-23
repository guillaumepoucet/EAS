<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Course;
use App\Entity\Session;
use App\Form\AddUserType;
use App\Form\AddCourseType;
use App\Form\AddSessionType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // retrieve users info
        $users = $userRepo->findAll();
        foreach ($users as $user) {
            $userId = $user->getId();
            $sessions = $userRepo->find($userId)->getSessions();
            foreach ($sessions as $session) {
                $course = $sessionRepo->find($session)->getCourse();
                $course = $courseRepo->find($course)->getCourseName();
            }
        }
        // dump($users);

        // retrieve courses info
        $courses = $courseRepo->findAll();
        // foreach ($courses as $course) {
        //     $userId = $user->getId();
        //     $sessions = $userRepo->find($userId)->getSessions();
        //     foreach ($sessions as $session) {
        //         $course = $sessionRepo->find($session)->getCourse();
        //         $course = $courseRepo->find($course)->getCourseName();
        //     }
        // }
        // dump($courses);

        // retrieve sessions info
        $sessions = $sessionRepo->findAll();
        // foreach ($courses as $course) {
        //     $userId = $user->getId();
        //     $sessions = $userRepo->find($userId)->getSessions();
        // foreach ($sessions as $session) {
            // $session_id = $session->getId();
            // $course = $sessionRepo->find($session)->getCourse();
            // $course = $courseRepo->find($session_id)->getCourseName();
        // }
        // }
        dump($sessions);

        // creating form to add users
        $newUser = new User;

        $userForm = $this->createForm(AddUserType::class, $newUser);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $newUser = $userForm->getData();

            // encode the plain password
            $newUser->setPassword(
                $passwordEncoder->encodePassword(
                    $newUser,
                    $userForm->get('password')->getData()
                )
            );

            $sessions = $userForm->get('sessions')->getData();
            $sessionsId = [];
            // foreach ($sessions as $session) {
            //     $sessionsId = $session;
            // };

            // $newUser->addSession($newUser)->getId();
            // dump($sessions);
            // exit;

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newUser);
            $entityManager->flush();

            // return $this->redirectToRoute('task_success');
        }

        // creating form to add courses
        $newCourse = new Course;

        $courseForm = $this->createForm(AddCourseType::class, $newCourse);

        $courseForm->handleRequest($request);
        if ($courseForm->isSubmitted() && $courseForm->isValid()) {
            $newCourse = $courseForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newCourse);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
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

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'courses' => $courses,
            'sessions' => $sessions,
            'userForm' => $userForm->createView(),
            'courseForm' => $courseForm->createView(),
            'sessionForm' => $sessionForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete/user/{id}", name="delete_user")
     */

    public function deleteUser(UserRepository $userRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $userRepo->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/delete/course/{id}", name="delete_course")
     */

    public function deleteCourse(CourseRepository $courseRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $course = $courseRepo->find($id);
        $entityManager->remove($course);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/delete/session/{id}", name="delete_session")
     */

    public function deleteSession(SessionRepository $sessionRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $sessionRepo->find($id);
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }
}
