<?php

namespace App\DataFixtures;

use App\Entity\Pictures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PicturesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $picture1 = new Pictures();
        $picture1->setUrl('https://picsum.photos/200/300');
        $this->addReference('picture-1', $picture1);
        $manager->persist($picture1);


        $manager->flush();
    }
}
