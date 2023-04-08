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
                'date_widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Moi', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ],
            ])
            ->add('dateEnd', DateTimeType::class,  [
                'date_widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Moi', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ],
            ])

            ->add('visitor',EntityType::class,[
            'class' => 'App\Entity\User',
            'choice_label' => 'email',
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
