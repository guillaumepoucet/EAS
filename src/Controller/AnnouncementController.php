<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/announcement")
 */
class AnnouncementController extends AbstractController
{
    /**
     * @Route("/", name="announcement_index", methods={"GET"})
     */
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        return $this->render('announcement/index.html.twig', [
            'announcements' => $announcementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="announcement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // guaranty that the user won't be able to access this
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // set the current user as author
            $announcement->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($announcement);
            $entityManager->flush();
            
            // sends a flash messages for success
            $this->addFlash('success', 'Nouvelle annonce créée');

            return $this->redirectToRoute('announcement_index');
        }

        return $this->render('announcement/new.html.twig', [
            'announcement' => $announcement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="announcement_show", methods={"GET"})
     */
    public function show(Announcement $announcement): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('announcement/show.html.twig', [
            'announcement' => $announcement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="announcement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Announcement $announcement): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Annonce modifiée');

            return $this->redirectToRoute('announcement_index');    
        }
        
        return $this->render('announcement/edit.html.twig', [
            'announcement' => $announcement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="announcement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Announcement $announcement): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$announcement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($announcement);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Annonce supprimée');

        return $this->redirectToRoute('announcement_index');
    }
}
