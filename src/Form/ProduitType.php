<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Length([
                        'max' => 150
                    ])
                ]
            ])
            ->add('stock', NumberType::class)
            ->add('prix', NumberType::class)
            ->add('description', TextType::class)
            ->add('histoire', TextType::class)
            ->add('utilisation', TextType::class)

            ->add('tauxTva', NumberType::class)
            ->add('image', FileType::class, [
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        
                    ]),
                    
                    new Image
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
