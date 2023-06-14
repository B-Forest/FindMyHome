<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mail1 = new Contact();
        $mail1->setName('mail1');
        $mail1->setSubject('Problème de connexion');
        $mail1->setText("Bonjour j'ai un problème de connexion");
        $mail1->setEmail('client@gmail.com');
        $manager->persist($mail1);

        $mail2 = new Contact();
        $mail2->setName('mail2');
        $mail2->setSubject('Problème de photos');
        $mail2->setText("Bonjour j'ai un problème de photos");
        $mail2->setEmail('client2@gmail.com');
        $manager->persist($mail2);

        $manager->flush();
    }


}
