<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="users.management")
     */
    public function index(UserRepository $userRepo)
    {
        // retrieve users info
        $users = $userRepo->findAll();

        return $this->render('admin/users_management/index.html.twig', [
            'controller_name' => 'AdminUserController',
            'users' => $users,
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
        return $this->redirectToRoute('users.management');
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
            'controller_name' => 'AdminUserController',
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

            $user = $userForm->getData();
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('users.management');
        }

        return $this->render('admin/users_management/editUser.html.twig', [
            'controller_name' => 'AdminUserController',
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