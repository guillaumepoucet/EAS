<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAnnouncementController extends AbstractController
{
    /**
     * @Route("/admin/announcement", name="admin_announcement")
     */
    public function index()
    {
        return $this->render('admin_announcement/index.html.twig', [
            'controller_name' => 'AdminAnnouncementController',
        ]);
    }

    /**
     * @Route("/admin/announcement/edit/{id}", name="edit.announcement")
     */
    public function editAnnouncement(Request $request, Announcement $id)
    {

        $announcementForm = $this->createForm(AnnouncementType::class, $id);

        $announcementForm->handleRequest($request);
        if ($announcementForm->isSubmitted() && $announcementForm->isValid()) {

            $user = $announcementForm->getData();
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'controller_name' => 'AdminAnnouncementController',
            'announcement' => $id,
            'announcementForm' => $announcementForm->createView(),
        ]);

        return $this->render('admin_announcement/index.html.twig', [
            'controller_name' => 'AdminAnnouncementController',
        ]);
    }
}
