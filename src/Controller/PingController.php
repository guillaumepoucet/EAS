<?php

namespace App\Controller;

use Symfony\Flex\Response;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\PublisherInterface;

/**
 * @Route("/ping", name="ping")
 */
class PingController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function index()
    {
        return $this->render('ping/index.html.twig', [
            'controller_name' => 'PingController',
        ]);
    }

    /**
     * @Route("/send", name="_send", methods={"POST"})
     */
    public function sendPing(PublisherInterface $publisher)
    {
        $update = new Update(
            'http://localhost:8000/ping/send', "[]");

        // Sync, or async (RabbitMQ, Kafka...)
        $publisher($update);

        return $this->redirectToRoute('ping');
    }
}
