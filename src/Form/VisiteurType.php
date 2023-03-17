<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Visit;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VisiteurType extends AbstractType
{
    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->token->getToken()?->getUser();
        $builder
            ->add('visitor', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $userRepository) use ($user) {
                    return $userRepository->createQueryBuilder('u')
                        ->where('u.id = :id')
                        ->setParameter('id', $user->getId());
                },
                'choice_label' => 'firstName',
                'label' => 'Vous allez vous inscrire avec le compte :',
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
