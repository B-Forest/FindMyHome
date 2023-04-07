<?php

namespace App\Form;


use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterPropertyType extends AbstractType
{
    const Rooms = [
        1 => '1 pièce',
        2 => '2 pièces',
        3 => '3 pièces',
        4 => '4 pièces',
        5 => '5 pièces',
        6 => '6 pièces',
        7 => '7 pièces',
        8 => '8 pièces',
        9 => '9 pièces',
        10 => '10 pièces et plus',
    ];
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                ],
            ])
            ->add('zipcode', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal',
                ],
            ])
            ->add('minPrice', NumberType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix min',
                ],
            ])
            ->add('maxPrice', NumberType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix max',
                ],
            ])

            ->add('minSurface', NumberType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface min',
                ],
            ])

            ->add('maxSurface', NumberType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface max',
                ],
            ])

            ->add('category',EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
                'required' => false,
                'label' => false,
                'placeholder' => 'Catégorie',
            ])
            ->add('payment',EntityType::class, [
                'class' => 'App\Entity\Payment',
                'choice_label' => 'name',
                'required' => false,
                'label' => false,
                'placeholder' => 'Type de bien',
            ])
            ->add('minRoom', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Nombre de pièces min',
                'choices' => self::Rooms,
            ])
            ->add('maxRoom', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Nombre de pièces max',
                'choices' => self::Rooms,
            ])
        ;
    }

}
