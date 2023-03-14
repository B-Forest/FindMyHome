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
        $julick->setProfilePicture('https://imgs.search.brave.com/uNKtgLgRKteWDQaxSZvsNHsc7XOlUps0o0jB881KPSw/rs:fit:847:225:1/g:ce/aHR0cHM6Ly90c2Uz/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC55/dWxUT0x1S2phRlFE/SWNhS3BaTUFRSGFF/SiZwaWQ9QXBp');
        $julick->setRoles(['ROLE_USER']);
        $manager->persist($julick);
        $this->setReference('user-julick', $julick);

        $theau =new User();
        $theau->setEmail('theau.dup@gmail.com');
        $theau->setPassword($this->hasher->hashPassword($theau, 'theau'));
        $theau->setFirstName('Theau');
        $theau->setLastName('Dup');
        $theau->setPhoneNumber('0600000001');
        $theau->setProfilePicture('https://imgs.search.brave.com/uNKtgLgRKteWDQaxSZvsNHsc7XOlUps0o0jB881KPSw/rs:fit:847:225:1/g:ce/aHR0cHM6Ly90c2Uz/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC55/dWxUT0x1S2phRlFE/SWNhS3BaTUFRSGFF/SiZwaWQ9QXBp');
        $theau->setRoles(['ROLE_USER']);
        $manager->persist($theau);
        $this->setReference('user-theau', $theau);

        $benjamin =new User();
        $benjamin->setEmail('benjamin.forest@gmail.com');
        $benjamin->setPassword($this->hasher->hashPassword($benjamin, 'benjamin'));
        $benjamin->setFirstName('Benjamin');
        $benjamin->setLastName('Forest');
        $benjamin->setPhoneNumber('0600000002');
        $benjamin->setProfilePicture('https://imgs.search.brave.com/uNKtgLgRKteWDQaxSZvsNHsc7XOlUps0o0jB881KPSw/rs:fit:847:225:1/g:ce/aHR0cHM6Ly90c2Uz/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC55/dWxUT0x1S2phRlFE/SWNhS3BaTUFRSGFF/SiZwaWQ9QXBp');
        $benjamin->setRoles(['ROLE_ADMIN']);
        $manager->persist($benjamin);
        $this->setReference('user-benjamin', $benjamin);

        $michel =new User();
        $michel->setEmail('michel.truc@gmail.com');
        $michel->setPassword($this->hasher->hashPassword($michel, 'michel'));
        $michel->setFirstName('Michel');
        $michel->setLastName('Truc');
        $michel->setPhoneNumber('0600000003');
        $michel->setProfilePicture('https://imgs.search.brave.com/uNKtgLgRKteWDQaxSZvsNHsc7XOlUps0o0jB881KPSw/rs:fit:847:225:1/g:ce/aHR0cHM6Ly90c2Uz/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC55/dWxUT0x1S2phRlFE/SWNhS3BaTUFRSGFF/SiZwaWQ9QXBp');
        $michel->setRoles(['ROLE_USER']);
        $manager->persist($michel);
        $this->setReference('user-michel', $michel);



        $manager->flush();
    }
}
