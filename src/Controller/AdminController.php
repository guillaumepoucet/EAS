<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(AnnouncementRepository $announcementRepo, UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo)
    {
        // retrieve users info
        $users = $userRepo->findAll();

        // retrieve courses info
        $courses = $courseRepo->findAll();

        // retrieve sessions info
        $sessions = $sessionRepo->findAll();

        $announcements = $announcementRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'courses' => $courses,
            'sessions' => $sessions,
            'announcements' => $announcements,
        ]);
    }


}
