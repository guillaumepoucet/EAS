<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("admin@user.com");
        $manager->persist($user);

        // $faker = Faker\Factory::create('fr_FR');
        // $user = [];
        
        // for ($i = 0; $i < 2; $i++) {
        //     $user[$i] = new User();
        //     $user[$i]->setPassword($this->passwordEncoder->encodePassword(
        //         $user[$i],
        //         'pass'
        //     ));
        // }
        

        $manager->flush();
    }
}
