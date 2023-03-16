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
        $visit1->setDateStart($today->modify('+2 day'));
        $visit1->setDateEnd($today->modify('+2 day + 1 hour'));
        $visit1->setProperty($this->getReference('maison-1'));
        $this->addReference('visit-1', $visit1);
        $manager->persist($visit1);

        $visit2 = new Visit();
        $visit2->setDateStart($today->modify('+3 day'));
        $visit2->setDateEnd($today->modify('+3 day + 1 hour'));
        $visit2->setProperty($this->getReference('maison-2'));
        $visit2->setVisitor($this->getReference('user-julick'));
        $this->addReference('visit-2', $visit2);
        $manager->persist($visit2);

        $visit3 = new Visit();
        $visit3->setDateStart($today->modify('-4 day'));
        $visit3->setDateEnd($today->modify('-4 day + 1 hour'));
        $visit3->setProperty($this->getReference('maison-1'));
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
