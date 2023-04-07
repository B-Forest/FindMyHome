<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $julick =new User();
        $julick->setEmail('julick.mellah@gmail.com');
        $julick->setPassword($this->hasher->hashPassword($julick, 'julick'));
        $julick->setFirstName('Julick');
        $julick->setLastName('Mellah');
        $julick->setPhoneNumber('0600000000');
        $julick->setProfilePicture('placeholderpp.png');
        $julick->setRoles(['ROLE_USER']);
        $manager->persist($julick);
        $this->setReference('user-julick', $julick);

        $theau =new User();
        $theau->setEmail('theau.dup@gmail.com');
        $theau->setPassword($this->hasher->hashPassword($theau, 'theau'));
        $theau->setFirstName('Theau');
        $theau->setLastName('Dup');
        $theau->setPhoneNumber('0600000001');
        $theau->setProfilePicture('placeholderpp.png');
        $theau->setRoles(['ROLE_USER']);
        $manager->persist($theau);
        $this->setReference('user-theau', $theau);

        $benjamin =new User();
        $benjamin->setEmail('benjamin.forest@gmail.com');
        $benjamin->setPassword($this->hasher->hashPassword($benjamin, 'benjamin'));
        $benjamin->setFirstName('Benjamin');
        $benjamin->setLastName('Forest');
        $benjamin->setPhoneNumber('0600000002');
        $benjamin->setProfilePicture('placeholderpp.png');
        $benjamin->setRoles(['ROLE_ADMIN']);
        $manager->persist($benjamin);
        $this->setReference('user-benjamin', $benjamin);

        $michel =new User();
        $michel->setEmail('michel.truc@gmail.com');
        $michel->setPassword($this->hasher->hashPassword($michel, 'michel'));
        $michel->setFirstName('Michel');
        $michel->setLastName('Truc');
        $michel->setPhoneNumber('0600000003');
        $michel->setProfilePicture('placeholderpp.png');
        $michel->setRoles(['ROLE_USER']);
        $manager->persist($michel);
        $this->setReference('user-michel', $michel);



        $manager->flush();
    }
}
