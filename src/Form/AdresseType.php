<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,
           [ 'label' => 'votre nom'
           ])
            ->add('numero', NumberType::class, [ 'label' => 'votre numero'
            ])
            ->add('rue', TextType::class, [ 'label' => 'votre numero de rue'])
            ->add('cp', NumberType::class, [ 'label' => 'votre code postal'])
            ->add('ville', TextType::class, ['label' => 'votre ville'])
            ->add('pays', CountryType::class, ['label' => 'votre pays'])
            
            ->add('info', TextType::class, ['label' => 'adresse complémentaire'])
            ->add('societe', TextType::class, ['label' => 'votre société'])
            ->add('tel', TextType::class, [ 'label' => 'votre numero de téléphone'])
            ->add('nom_prenom', TextType::class, ['label' => 'votre nom et votre prénom'])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
