<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LocationsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $seeds = [
            [
                'zipcode' => '10115',
                'city'    => 'Berlin',
                'region'  => 'Berlin'
            ],
            [
                'zipcode' => '32457',
                'city'    => 'Porta Westfalica',
                'region'  => 'Porta Westfalica'
            ],
            [
                'zipcode' => '01623',
                'city'    => 'Lommatzsch',
                'region'  => 'Berlin'
            ],
            [
                'zipcode' => '21521',
                'city'    => 'Hamburg',
                'region'  => 'Hamburg'
            ],
            [
                'zipcode' => '06895',
                'city'    => 'Bülzig',
                'region'  => 'Bülzig'
            ],
            [
                'zipcode' => '01612',
                'city'    => 'Diesbar-Seußlitz',
                'region'  => 'Diesbar-Seußlitz'
            ],
        ];
        $now   = new \DateTime();
        foreach ($seeds as $seed) {
            $location = new Location();
            $location->setZipcode($seed['zipcode']);
            $location->setCity($seed['city']);
            $location->setRegion($seed['region']);
            $location->setCreatedAt($now);
            $location->setUpdatedAt($now);
            $manager->persist($location);
        }

        $manager->flush();
    }
}
