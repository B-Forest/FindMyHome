<?php

namespace App\DataFixtures;

use App\Entity\Visit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VisitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $today = new \DateTimeImmutable();

        $visit1 = new Visit();
        $visit1->setDate($today->modify('+2 day'));
        $visit1->setProperty($this->getReference('maison-1'));
        $visit1->addUser($this->getReference('user-theau'));
        $visit1->addUser($this->getReference('user-michel'));
        $this->addReference('visit-1', $visit1);
        $manager->persist($visit1);

        $visit2 = new Visit();
        $visit2->setDate($today->modify('+3 day'));
        $visit2->setProperty($this->getReference('maison-1'));
        $visit2->addUser($this->getReference('user-theau'));
        $visit2->addUser($this->getReference('user-michel'));
        $this->addReference('visit-2', $visit2);
        $manager->persist($visit2);

        $visit3 = new Visit();
        $visit3->setDate($today->modify('-4 day'));
        $visit3->setProperty($this->getReference('maison-1'));
        $visit3->addUser($this->getReference('user-theau'));
        $visit3->addUser($this->getReference('user-michel'));
        $this->addReference('visit-3', $visit3);
        $manager->persist($visit3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PropertyFixtures::class
        ];
    }
}
