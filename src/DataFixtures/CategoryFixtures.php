<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $appartement = new Category();
        $appartement->setName('appartement');
        $this->addReference('category-appartement', $appartement);
        $manager->persist($appartement);

        $maison = new Category();
        $maison->setName('maison');
        $this->addReference('category-maison', $maison);
        $manager->persist($maison);

        $manoir = new Category();
        $manoir->setName('manoir');
        $this->addReference('category-manoir', $manoir);
        $manager->persist($manoir);

        $terrain = new Category();
        $terrain->setName('terrain');
        $this->addReference('category-terrain', $terrain);
        $manager->persist($terrain);

        $manager->flush();
    }
}
