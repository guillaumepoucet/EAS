<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Course;
use App\Entity\Session;
use App\Form\AddUserType;
use App\Form\EditUserType;
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
            'courseForm' => $courseForm->createView(),
            'sessionForm' => $sessionForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/delete/user/{id}", name="delete.user")
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
     * @Route("/admin/delete/course/{id}", name="delete.course")
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
     * @Route("/admin/delete/session/{id}", name="delete.session")
     */

    public function deleteSession(SessionRepository $sessionRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $sessionRepo->find($id);
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/users", name="users.management")
     */

    public function userList(UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // retrieve users info
        $users = $userRepo->findAll();

        return $this->render('admin/users_management/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/new", name="admin.new.user")
     */

    public function newUser(UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
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
            foreach ($sessions as $session) {
                $session->addUser($newUser);
            };

            // dump($session);
            // exit;

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newUser);
            $entityManager->flush();

            return $this->redirectToRoute('users.management');
        }

        return $this->render('admin/users_management/newUser.html.twig', [
            'controller_name' => 'AdminController',
            'userForm' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin.edit.user")
     */

    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $userForm = $this->createForm(EditUserType::class, $user);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $userForm->getData();

            // encode the plain password
            // $user->setPassword(
            //     $passwordEncoder->encodePassword(
            //         $user,
            //         $userForm->get('password')->getData()
            //     )
            // );

            // dump($session);
            // exit;

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users.management');
        }

        return $this->render('admin/users_management/editUser.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user,
            'userForm' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/make_admin/{id}", name="admin.make.admin")
     */

    public function makeAdmin(User $user)
    {
        $user->setRoles(array("ROLE_ADMIN"));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('users.management');
    }

    /**
     * @Route("/admin/user/del_admin/{id}", name="admin.del.admin")
     */

    public function delAdmin(User $user)
    {
        $user->setRoles(array());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('users.management');
    }
}
