<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PropertyType extends AbstractType
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
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('surface')
            ->add('city')
            ->add('zipCode')
            ->add('address')
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('room', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'placeholder' => 'Nombre de pièces',
                'choices' => self::Rooms,
            ])
            ->add('payment',EntityType::class, [
                'class' => 'App\Entity\Payment',
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('pictures', FileType::class, [
                'multiple' => true,
                'attr' => ['accept' => 'image/*'],
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
