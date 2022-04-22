<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'constraints' => [
                new Email
            ]
        ])
        ->add('nom', TextType::class, [
            'constraints' => [
                new Length([
                    'max' => 150
                ])
            ]
        ])
        ->add('prenom', TextType::class, [
            'constraints' => [
                new Length([
                    'max' => 150
                ])
            ]
        ])
        ->add('message', TextareaType::class, [
            'constraints' => [
                new Length([
                    'max' => 1500
                ])
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer'
        ]);
}

public function configureOptions(OptionsResolver $resolver): void {
    $resolver->setDefaults([
        // Configure your form options here
    ]);
    }

    
}
