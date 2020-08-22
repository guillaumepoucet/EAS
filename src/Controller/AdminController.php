<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
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

        // creating form to add users
        $user = new User;

        $form = $this->createForm(AddUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // return $this->redirectToRoute('task_success');
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }
}
