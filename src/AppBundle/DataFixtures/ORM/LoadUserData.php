<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('123123123');
        $userAdmin->setEmail('resurtm+test-admin@gmail.com');
        $userAdmin->setIsActive(true);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
