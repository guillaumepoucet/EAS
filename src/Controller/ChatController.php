<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/messages", name="messages")
     */
class ChatController extends AbstractController
{
    /**
     * @Route("/{user}/{otherUser}", name="_index", defaults={"otherUser" = 3})
     */
    public function index(User $user, User $otherUser, Request $request, MessageRepository $msgRepo, UserRepository $userRepo)
    {

        $user_id = $user->getId();

        $userMessageList = [];
        $senderId = $msgRepo->getSenderId($user_id);
        $recipientId = $msgRepo->getRecipientId($user_id);

        // function makeUserList($id, $userRepo, $userMessageList): array
        // {
        //     if (!in_array($id[1], $userMessageList)) {
        //         $name = $userRepo->findOneBy(array('id' => $id[1]))->getName();
        //         $userMessageList[$id[1]] = array(
        //             'id' => $id[1],
        //             'name' => $name,
        //         );
        //     }
        //     return array($userMessageList);
        // }

        foreach ($senderId as $id) {
            if (!in_array($id[1], $userMessageList)) {
                $name = $userRepo->findOneBy(array('id' => $id[1]))->getName();
                $userMessageList[$id[1]] = array(
                    'id' => $id[1],
                    'name' => $name,
                );
            }
        }
        foreach ($recipientId as $id) {
            if (!in_array($id[1], $userMessageList)) {
                $name = $userRepo->findOneBy(array('id' => $id[1]))->getName();
                $userMessageList[$id[1]] = array(
                    'id' => $id[1],
                    'name' => $name,
                );
            }
        };

        $other_id = $otherUser->getId();
        $messages = $msgRepo->messages($user_id, $other_id);

        $newMessage = new Message();

        $chatForm = $this->createForm(MessageType::class, $newMessage);

        $chatForm->handleRequest($request);
        if ($chatForm->isSubmitted() && $chatForm->isValid()) {
            $newMessage = $chatForm->getData();

            $date = date('Y-m-d H:i:s');
            $newMessage->setMessageDate(\DateTime::createFromFormat('Y-m-d H:i:s', $date));
            $newMessage->setSender($user);
            $newMessage->setRecipient($otherUser);
            $newMessage->setIsReported(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMessage);
            $entityManager->flush();

            return $this->redirectToRoute('messages_index', array(
                'user' => $user_id,
                'otherUser' => $other_id,
            ));
        }

        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'userList' => $userMessageList,
            'messages' => $messages,
            'chatForm' => $chatForm->createView(),
        ]);
    }

    /**
     * @Route("/{user}/{otherUser}", name="_show")
     */
    public function msg(User $user, User $otherUser, MessageRepository $msgRepo, UserRepository $userRepo, Request $request)
    {
        $user_id = $user->getId();
        $other_id = $otherUser->getId();
        $messages = $msgRepo->messages($user_id, $other_id);

        $newMessage = new Message();

        $chatForm = $this->createForm(MessageType::class, $newMessage);

        $chatForm->handleRequest($request);
        if ($chatForm->isSubmitted() && $chatForm->isValid()) {
            $newMessage = $chatForm->getData();

            $date = date('Y-m-d H:i:s');
            $newMessage->setMessageDate(\DateTime::createFromFormat('Y-m-d H:i:s', $date));
            $newMessage->setSender($user);
            $newMessage->setRecipient($otherUser);
            $newMessage->setIsReported(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMessage);
            $entityManager->flush();

            return $this->redirectToRoute('chat.show', array(
                'user' => $user_id,
                'otherUser' => $other_id,
            ));
        }


        return $this->render('chat/_conv.html.twig', [
            'controller_name' => 'ChatController',
            'messages' => $messages,
            'chatForm' => $chatForm->createView(),
        ]);
    }
}
