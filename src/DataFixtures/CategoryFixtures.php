<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $seeds = [
            [
                'id'   => 804040,
                'name' => 'Sonstige Umzugsleistungen'
            ],
            [
                'id'   => 802030,
                'name' => 'Abtransport, Entsorgung und Entrümpelung'
            ],
            [
                'id'   => 411070,
                'name' => 'Fensterreinigung'
            ],
            [
                'id'   => 402020,
                'name' => 'Holzdielen schleifen'
            ],
            [
                'id'   => 108140,
                'name' => 'Kellersanierung'
            ]
        ];
        $now   = new \DateTime();
        foreach ($seeds as $seed) {
            $category = new Category();
            $metadata = $manager->getClassMetadata(Category::class);
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $category->setId($seed['id']);
            $category->setName($seed['name']);
            $category->setCreatedAt($now);
            $category->setUpdatedAt($now);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
