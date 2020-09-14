<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\SessionRepository;
use App\Repository\AnnouncementRepository;
use App\Repository\DocumentRepository;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("", name="_dashboard")
     */
    public function index(AnnouncementRepository $announcementRepo, UserRepository $userRepo, SessionRepository $sessionRepo, CourseRepository $courseRepo, MessageRepository $messageRepo, DocumentRepository $documentRepo)
    {
        $user = $this->getUser();

        $sessions = $userRepo->find($user)->getSessions();
        foreach ($sessions as $session) {
            $session_id = $session->getId();
            $course = $sessionRepo->find($session_id)->getCourse()->getId();
            $files = $courseRepo->find($course)->getDocument();
            // foreach ($course as $c) {
            //     // $file = $c->getDocument();
                dump($files);
            // }
            
        }

        $announcements = $announcementRepo->findAll();

        $messages = $messageRepo->findBy(array('recipient' => $user), array('message_date' => 'DESC'), 2);
    
        $files = $documentRepo->getUsersDocuments($user->getId(), 2);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            // 'sessions' =>  $sessionTable,
            'announcements' => $announcements,
            'messages' => $messages,
            'files' => $files,
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
