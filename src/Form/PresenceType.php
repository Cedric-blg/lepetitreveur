<?php

namespace App\Form;

use App\Entity\Presence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_day', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
            ])
            ->add('arrival_hour', TimeType::class, [
                'label' => 'Heure d\'arrivée',
            ])
            ->add('departure_time', TimeType::class, [
                'label' => 'Heure de départ',
            ])
            // Unmapped text input used by Stimulus autocomplete
            ->add('child_search', TextType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Enfant',
                'attr' => [
                    'placeholder' => 'Rechercher un enfant...',
                    'data-controller' => 'autocomplete',
                    'data-action' => 'input->autocomplete#search',
                    'data-autocomplete-target' => 'input',
                    // configure controller for children search
                    'data-autocomplete-search-url' => '/child/child-search',
                    // hidden input that will be posted
                    'data-autocomplete-hidden-name' => 'child_id',
                    // single selection
                    'data-autocomplete-multiple' => '0',
                    // initial value when editing
                    'data-autocomplete-initial-id' => $builder->getData() && $builder->getData()->getChild() ? $builder->getData()->getChild()->getId() : '',
                    'data-autocomplete-initial-text' => $builder->getData() && $builder->getData()->getChild() ? trim(($builder->getData()->getChild()->getFirstName() ?? '') . ' ' . ($builder->getData()->getChild()->getName() ?? '')) : '',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presence::class,
        ]);
    }
}
