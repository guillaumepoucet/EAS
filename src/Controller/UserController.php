<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use App\Repository\AnnouncementRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
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

        // dump($sessionTable);

        $announcements = $announcementRepo->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'sessions' =>  $sessionTable,
            'announcements' => $announcements,
        ]);
    }
}
