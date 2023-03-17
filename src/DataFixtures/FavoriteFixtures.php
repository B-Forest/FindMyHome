<?php

namespace App\DataFixtures;

use App\Entity\Favorite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FavoriteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $favoriteJulick = new Favorite();
        $favoriteJulick->setUser($this->getReference('user-julick'));
        $favoriteJulick->addProperty($this->getReference('maison-2'));
        $favoriteJulick->addProperty($this->getReference('maison-1'));
        $this->addReference('favorite', $favoriteJulick);
        $manager->persist($favoriteJulick);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PropertyFixtures::class,
        ];
    }
}
