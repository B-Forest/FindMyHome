<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Visit;
use App\Repository\PropertyRepository;
use Cassandra\Type\UserType;
use Monolog\DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VisitType extends AbstractType
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
            ->add('date', DateTimeImmutable::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ],
            ])
            ->add('property',EntityType::class, [
                'class' => Property::class,
                'query_builder' => function (PropertyRepository $propertyRepository) use($user) {
                    return $propertyRepository->createQueryBuilder('property')
                        ->where('property.manager = :id')
                            ->setParameter(':id', $user->getId());
                },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('promoteur')
            ->add('visitor',CollectionType::class, [
                'entry_type' => UserType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
