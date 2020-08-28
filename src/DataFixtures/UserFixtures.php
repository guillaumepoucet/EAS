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

        // $user = new User();
        // $user->setEmail("admin@user.com");
        
        $faker = Faker\Factory::create('fr_FR');

        $user = [];
        
        for ($i = 3; $i < 5; $i++) {
            $user[$i] = new User();
            $user[$i]->setEmail('user'.$i.'@user.com');
            $user[$i]->setLastName($faker->lastname);
            $user[$i]->setLastName($faker->lastname);
            $user[$i]->setFirstName($faker->firstname);
            $user[$i]->setPassword($this->passwordEncoder->encodePassword(
                $user[$i],
                'password'
            ));
            $user[$i]->setBirthDate($faker->dateTime($format = 'Y-m-d'));
            $manager->persist($user[$i]);
        }
        
        $manager->flush();
    }
}
