<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Transport;
use App\Entity\Adressefact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegroupType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $user = $options['user'];

    $builder
        ->add('Adresse', EntityType::class, [
            'label' => 'Choisissez votre adresse de livraison',
            'required' => true,
            'class' => Adresse::class,
            'choices' => $user->getAdresses(),
            'multiple' => false,
            'expanded' => true,
        ])
        ->add('Adressefact', EntityType::class, [
            'label' => 'Choisissez votre adresse de facturation',
            'required' => true,
            'class' => Adressefact::class,
            'choices' => $user->getAdressefacts(),
            'multiple' => false,
            'expanded' => true,
        ])
        ->add('transport', EntityType::class, [
            'label' => 'Choisissez votre livraison',
            'required' => true,
            'class' => Transport::class,
            'multiple' => false,
            'expanded' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Valider ma commande',
            'attr' => [
                'class' => 'btn btn-primary m-3'
            ]
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user'=>array(),
        ]);
    }
}
