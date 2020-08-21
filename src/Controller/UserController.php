<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(SessionRepository $repo)
    {
        $user = $this->getUser();
        $user_id = $user->getId();

        $session = $repo->findBy(array(
            'id' => 1
        ));

        $test = $session[0]->getUser();

        dump($test);


        // dump($user);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            
        ]);
    }
}
