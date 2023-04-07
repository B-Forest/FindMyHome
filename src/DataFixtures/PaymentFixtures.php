<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $short = new Payment();
        $short->setName('Courte durée');
        $this->addReference('payment-journalier', $short);
        $manager->persist($short);

        $long = new Payment();
        $long->setName('Longue durée');
        $this->addReference('payment-mensuel', $long);
        $manager->persist($long);

        $achat = new Payment();
        $achat->setName('Achat');
        $this->addReference('payment-achat', $achat);
        $manager->persist($achat);

        $manager->flush();
    }
}
