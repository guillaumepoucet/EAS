<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request, UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo)
    {
        // retrieve users info
        $users = $userRepo->findAll();

        // retrieve courses info
        $courses = $courseRepo->findAll();

        // retrieve sessions info
        $sessions = $sessionRepo->findAll();

        // creating form to add course sessions
        $newAnnouncement = new Announcement;

        $announcementForm = $this->createForm(AnnouncementType::class, $newAnnouncement);

        $announcementForm->handleRequest($request);
        if ($announcementForm->isSubmitted() && $announcementForm->isValid()) {
            $newAnnouncement = $announcementForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAnnouncement);
            $entityManager->flush();

            return $this->redirectToRoute('sessions.management');
        }


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'courses' => $courses,
            'sessions' => $sessions,
            'announcementForm' => $announcementForm->createView(),
        ]);
    }
}
