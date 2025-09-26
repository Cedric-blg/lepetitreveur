<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('first_name', null, [
                'label' => 'Prénom',
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date anniversaire',
            ])
            ->add('allergies', null, [
                'label' => 'Allergies',
                'required' => false,
            ])
            ->add('users', TextType::class, [
                'required' => false,
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
