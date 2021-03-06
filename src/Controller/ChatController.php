<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Symfony\Component\Mercure\Update;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/messages", name="messages")
 */
class ChatController extends AbstractController
{
    /**
     * @Route("/{user}", name="_index")
     */
    public function index(User $user, Request $request, MessageRepository $msgRepo, UserRepository $userRepo, PublisherInterface $publisher)
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

        $userId = $this->getUser()->getId();
        $aQuiParle[0] = $userId;

        foreach ($recipientId as $id) {
            if (!in_array($id[1], $userMessageList)) {
                $name = $userRepo->findOneBy(array('id' => $id[1]))->getName();
                $userMessageList[$id[1]] = array(
                    'id' => $id[1],
                    'name' => $name,
                );
            }
        };

        foreach ($senderId as $id) {
            if (!in_array($id[1], $userMessageList)) {
                $name = $userRepo->findOneBy(array('id' => $id[1]))->getName();
                array_push($aQuiParle, $id[1]);
                $userMessageList[$id[1]] = array(
                    'id' => $id[1],
                    'name' => $name,
                );
            }
        }

        $alluser = $userRepo->findAll();
        $i = 0;
        $tabUser = [];
        foreach ($alluser as $value) {
            array_push($tabUser, $value->getId());
            $i++;
        }

        //le tableau a qui il peut parler
        $aQuiPeutParler = array_diff($tabUser, $aQuiParle);
        $newRecipientList = [];

        foreach ($aQuiPeutParler as $a) {
            $name = $userRepo->find($a)->getName();
            $newRecipientList[$a] = array(
                'id' => $a,
                'name' => $name,
            );
        }
        
        $default_user = reset($userMessageList);
        $default_user = $default_user['id'];
        $messages = $msgRepo->messages($user_id, $default_user);

        $newMessage = new Message();

        $chatForm = $this->createForm(MessageType::class, $newMessage);

        $chatForm->handleRequest($request);
        if ($chatForm->isSubmitted() && $chatForm->isValid()) {
            $newMessage = $chatForm->getData();

            $recipient = $userRepo->find($default_user);

            $date = date('Y-m-d H:i:s');
            $newMessage->setMessageDate(\DateTime::createFromFormat('Y-m-d H:i:s', $date));
            $newMessage->setSender($user);
            $newMessage->setRecipient($recipient);
            $newMessage->setIsReported(0);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newMessage);
            $entityManager->flush();

            return $this->redirectToRoute('messages_index', array(
                'user' => $user_id,
                'otherUser' => $recipient,
            ));
        }

        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'otherUser' => $default_user,
            'userList' => $userMessageList,
            'messages' => $messages,
            'newRecipientList' => $newRecipientList,
            'chatForm' => $chatForm->createView(),
        ]);
    }

    /**
     * @Route("/send/{user}", name="_send")
     */
    public function sendMessage(User $user, Request $request, MessageRepository $msgRepo, UserRepository $userRepo, PublisherInterface $publisher)
    {
        $user_id = $user->getId();

        $default_user = reset($userMessageList);
        $default_user = $default_user['id'];
        $messages = $msgRepo->messages($user_id, $default_user);

        $newMessage = new Message();

        $chatForm = $this->createForm(MessageType::class, $newMessage);

        $chatForm->handleRequest($request);
        if ($chatForm->isSubmitted() && $chatForm->isValid()) {
            $newMessage = $chatForm->getData();

            $recipient = $userRepo->find($default_user);

            $date = date('Y-m-d H:i:s');
            $newMessage->setMessageDate(\DateTime::createFromFormat('Y-m-d H:i:s', $date));
            $newMessage->setSender($user);
            $newMessage->setRecipient($recipient);
            $newMessage->setIsReported(0);

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($newMessage);
            // $entityManager->flush();

            $update = new Update(
                'http://localhost:8000/messages',
                "[]"
            );

            // Sync, or async (RabbitMQ, Kafka...)
            $publisher($update);

            return $this->redirectToRoute('messages_index', array(
                'user' => $user_id,
                'otherUser' => $recipient,
            ));
        }
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

            return $this->redirectToRoute('messages_show', array(
                'user' => $user_id,
                'otherUser' => $other_id,
            ));
        }


        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            // 'otherUser' => $default_user,
            // 'userList' => $userMessageList,
            'messages' => $messages,
            // 'newRecipientList' => $newRecipientList,
            'chatForm' => $chatForm->createView(),
        ]);
    }
}
