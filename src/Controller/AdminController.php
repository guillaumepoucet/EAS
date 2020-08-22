<?php

namespace App\Controller;

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
    public function index(UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo)
    {
        $users = $userRepo->findAll();
        foreach ($users as $user) {
            $userId = $user->getId();
            $sessions = $userRepo->find($userId)->getSessions();
            foreach ($sessions as $session) {
                $course = $sessionRepo->find($session)->getCourse();
                $course = $courseRepo->find($course)->getCourseName();
            }
        }

        dump($users);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,

        ]);
    }
}
