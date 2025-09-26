<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
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
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('password', null, [
                'label' => 'Mot de passe',
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date anniversaire',
            ])
            ->add('adress', null, [
                'label' => 'Adresse',
            ])
            ->add('phone', null, [
                'label' => 'Téléphone',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
