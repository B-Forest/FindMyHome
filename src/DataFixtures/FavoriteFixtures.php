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
        $this->addReference('favorite-julick', $favoriteJulick);
        $manager->persist($favoriteJulick);

        $favoriteTheau = new Favorite();
        $favoriteTheau->setUser($this->getReference('user-theau'));
        $favoriteTheau->addProperty($this->getReference('maison-1'));
        $this->addReference('favorite-theau', $favoriteTheau);
        $manager->persist($favoriteTheau);

        $favoriteBenjamin = new Favorite();
        $favoriteBenjamin->setUser($this->getReference('user-benjamin'));
        $favoriteBenjamin->addProperty($this->getReference('maison-1'));
        $this->addReference('favorite-ben', $favoriteBenjamin);
        $manager->persist($favoriteBenjamin);


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
