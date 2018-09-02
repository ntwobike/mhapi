<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $seeds = [
            [
                'name'     => 'john',
                'email'    => 'john@doe.com',
                'password' => 'secret'
            ],
            [
                'name'     => 'jane',
                'email'    => 'jane@doe.com',
                'password' => 'secret'
            ],

        ];
        $now   = new \DateTime();
        foreach ($seeds as $seed) {
            $user = new User();
            $user->setName($seed['name']);
            $user->setEmail($seed['email']);
            $user->setPassword($seed['password']);
            $user->setCreatedAt($now);
            $user->setUpdatedAt($now);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
