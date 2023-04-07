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
        '0 pièce' => 0,
        '1 pièce' => 1,
        '2 pièces' => 2,
        '3 pièces' => 3,
        '4 pièces' => 4,
        '5 pièces' => 5,
        '6 pièces' => 6,
        '7 pièces' => 7,
        '8 pièces' => 8,
        '9 pièces' => 9,
        '10 pièces et plus' => 10,
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
