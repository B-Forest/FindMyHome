<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $t1 = new Category();
        $t1->setName('appartement-t1');
        $this->addReference('category-t1', $t1);
        $manager->persist($t1);

        $t2 = new Category();
        $t2->setName('appartement-t2');
        $this->addReference('category-t2', $t2);
        $manager->persist($t2);

        $t3 = new Category();
        $t3->setName('appartement-t3');
        $this->addReference('category-t3', $t3);
        $manager->persist($t3);

        $t4 = new Category();
        $t4->setName('appartement-t4');
        $this->addReference('category-t4', $t4);
        $manager->persist($t4);

        $t5 = new Category();
        $t5->setName('appartement-t5');
        $this->addReference('category-t5', $t5);
        $manager->persist($t5);

        $t6 = new Category();
        $t6->setName('appartement-t6');
        $this->addReference('category-t6', $t6);
        $manager->persist($t6);

        $m1 = new Category();
        $m1->setName('maison-m1');
        $this->addReference('category-maison', $m1);
        $manager->persist($m1);

        $manager->flush();
    }
}
