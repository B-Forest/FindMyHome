<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $journalier = new Payment();
        $journalier->setName('journalier');
        $this->addReference('payment-journalier', $journalier);
        $manager->persist($journalier);

        $hebdomadaire = new Payment();
        $hebdomadaire->setName('hebdomadaire');
        $this->addReference('payment-hebdomadaire', $hebdomadaire);
        $manager->persist($hebdomadaire);

        $mensuel = new Payment();
        $mensuel->setName('mensuel');
        $this->addReference('payment-mensuel', $mensuel);
        $manager->persist($mensuel);

        $trimestriel = new Payment();
        $trimestriel->setName('trimestriel');
        $this->addReference('payment-trimestriel', $trimestriel);
        $manager->persist($trimestriel);

        $semestriel = new Payment();
        $semestriel->setName('semestriel');
        $this->addReference('payment-semestriel', $semestriel);
        $manager->persist($semestriel);

        $annuel = new Payment();
        $annuel->setName('annuel');
        $this->addReference('payment-annuel', $annuel);
        $manager->persist($annuel);

        $achat = new Payment();
        $achat->setName('achat');
        $this->addReference('payment-achat', $achat);
        $manager->persist($achat);

        $manager->flush();
    }
}
