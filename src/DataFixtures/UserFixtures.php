<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;  
    }

    public function load(ObjectManager $manager)
    {
        /**
         * @param User $user
         */
        $user = new User();

        $plainPassword = "demo";
        $password = $this->encoder->encodePassword($user, $plainPassword);

        $user->setEmail("demo@gmail.com");
        $user->setPassword($password);
        $user->setPermission("Administrateur");
        $user->setName("demo");
        $user->setCode("123456");

        $manager->persist($user);

        $manager->flush();
    }
}
