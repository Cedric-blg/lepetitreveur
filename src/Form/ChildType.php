<?php

namespace App\Form;

use App\Entity\Activities;
use App\Entity\Child;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('first_name')
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('allergies', null, [
                'required' => false,
            ])
            ->add('users', TextType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un parent...',
                    'data-controller' => 'autocomplete',
                    'data-action' => 'input->autocomplete#search',
                    'data-autocomplete-target' => 'input',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
