<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo)
    {
        $user = $this->getUser();
        $sessions = $userRepo->find($user)->getSessions();
        $sessionTable = [];
        foreach ($sessions as $session) {
            $course = $sessionRepo->find($session)->getCourse();
            $course = $courseRepo->find($course)->getCourseName();
            $sessionTable[] = $session;
        }

        // dump($sessionTable);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'sessions' =>  $sessionTable,
        ]);
    }
}
