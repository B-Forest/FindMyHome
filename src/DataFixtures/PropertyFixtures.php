<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class PropertyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $firsthouse = new Property();
        $firsthouse->setName('ma première maison');
        $firsthouse->setDescription('Petite maison de campagne');
        $firsthouse->setPrice(200000);
        $firsthouse->setSurface(100);
        $firsthouse->setCity('Rennes');
        $firsthouse->setAddress('1 rue de la soif');
        $firsthouse->setOwner($this->getReference('user-julick'));
        $firsthouse->setCategory($this->getReference('category-t3'));
        $firsthouse->setPayment($this->getReference('payment-mensuel'));
        $manager->persist($firsthouse);
        $this->setReference('maison-1', $firsthouse);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            PaymentFixtures::class
        ];
    }
}
