<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Visit;
use App\Repository\PropertyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            ->add('property',EntityType::class, [
                'class' => Property::class,
                'query_builder' => function (PropertyRepository $propertyRepository) use($user) {
                    return $propertyRepository->createQueryBuilder('property')
                        ->where('property.owner = :id')
                            ->setParameter(':id', $user->getId());
                },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visit::class,
        ]);
    }
}
