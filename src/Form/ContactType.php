<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=> [
                    'minlength' => 2,
                    'maxlength' => 50,
                ],
                'label' => 'Nom/Prénom',
                'required' => false,
                ])
            ->add('email',EmailType::class, [
                'attr'=> [
                    'minlength' => 2,
                    'maxlength' => 255,
                ],
                'label' => 'Email',
                'constraints' => [
                    new Assert\Email(),
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 255,
                    ]),
                ],
                ])
            ->add('subject',TextType::class, [
                'attr'=> [
                    'minlength' => 2,
                    'maxlength' => 100,
                ],
                'label' => 'Sujet',
                'required' => false,
            ])
            ->add('text',TextareaType::class, [
                'attr'=> [
                    'minlength' => 2,
                    'maxlength' => 255,
                ],
                'label' => 'Votre message',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
