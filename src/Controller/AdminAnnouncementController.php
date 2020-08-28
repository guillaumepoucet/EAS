<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAnnouncementController extends AbstractController
{
    /**
     * @Route("/admin/announcement/add", name="add.announcement")
     */
    public function index(Request $request)
    {
        // creating form to add course sessions
        $newAnnouncement = new Announcement;

        $announcementForm = $this->createForm(AnnouncementType::class, $newAnnouncement);

        $announcementForm->handleRequest($request);
        if ($announcementForm->isSubmitted() && $announcementForm->isValid()) {
            $newAnnouncement = $announcementForm->getData();

            $newAnnouncement->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAnnouncement);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/announcements_management/form.html.twig', [
            'controller_name' => 'AdminAnnouncementController',
            'announcementForm' => $announcementForm->createView(),
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

        return $this->render('admin/announcements_management/form.html.twig', [
            'controller_name' => 'AdminAnnouncementController',
            'announcement' => $id,
            'announcementForm' => $announcementForm->createView(),
            'button' => 'Enregistrer',
        ]);

        return $this->render('admin_announcement/index.html.twig', [
            'controller_name' => 'AdminAnnouncementController',
        ]);
    }
}