<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nickname', TextType::class, [
            'label' => 'Votre pseudo',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('content', TextareaType::class, [
            'label' => 'Votre commentaire',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('rgpd', CheckboxType::class, [
            'label' => 'j/accepte de mettre mes données personnelles',
            'attr' => [
                'class' => 'form-control'
            ],
            'constraints' => [
                new NotBlank()
            ]
        ])
        ->add('parentid', HiddenType::class, [
            'mapped' => false
        ])
        ->add('envoyer', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
