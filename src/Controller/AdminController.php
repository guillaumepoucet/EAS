<?php

namespace App\Controller;

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
    public function index(UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo)
    {
        // retrieve users info
        $users = $userRepo->findAll();

        // retrieve courses info
        $courses = $courseRepo->findAll();

        // retrieve sessions info
        $sessions = $sessionRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'courses' => $courses,
            'sessions' => $sessions,
        ]);
    }
}
