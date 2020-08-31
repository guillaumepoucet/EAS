<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use App\Repository\AnnouncementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index(AnnouncementRepository $announcementRepo, UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo)
    {
        $user = $this->getUser();
        $sessions = $userRepo->find($user)->getSessions();
        $sessionTable = [];
        foreach ($sessions as $session) {
            $course = $sessionRepo->find($session)->getCourse();
            $course = $courseRepo->find($course)->getCourseName();
            $sessionTable[] = $session;
        }

        $announcements = $announcementRepo->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'sessions' =>  $sessionTable,
            'announcements' => $announcements,
        ]);
    }

    /**
     * @Route("/edit/{user}", name="_edit")
     */
    public function editProfile(User $user, Request $request)
    {
        $userForm = $this->createForm(EditUserType::class, $user);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $user = $userForm->getData();
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('user');
        }


        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'userForm' => $userForm->createView(),
        ]);
    }
}
