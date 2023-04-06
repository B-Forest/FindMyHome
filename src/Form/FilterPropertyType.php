<?php

namespace App\Form;


use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterPropertyType extends AbstractType
{
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
        ;
    }

}
