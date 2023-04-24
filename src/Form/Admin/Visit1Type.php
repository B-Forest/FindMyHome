<?php

namespace App\Form\Admin;

use App\Entity\Property;
use App\Entity\Visit;
use App\Repository\PropertyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Visit1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateTimeType::class,  [
                'html5' => true,
                'widget' => 'single_text',
                'attr'  => [
                    'min' => (new \DateTime('now'))->format('Y-m-d H:i'),
                    'max' => (new \DateTime('+1 year'))->format('Y-m-d H:i'),
                ],
            ])
            ->add('dateEnd', DateTimeType::class,  [
                'html5' => true,
                'widget' => 'single_text',
                'attr'  => [
                    'min' => (new \DateTime('now'))->format('Y-m-d H:i'),
                    'max' => (new \DateTime('+1 year'))->format('Y-m-d H:i'),
                ],
            ])

            ->add('visitor',EntityType::class,[
            'class' => 'App\Entity\User',
            'choice_label' => 'email',
            'placeholder' => 'Choisir un visiteur',
            ])
            ->add('property',EntityType::class,[
                'class' => 'App\Entity\Property',
                'choice_label' => 'name',
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
