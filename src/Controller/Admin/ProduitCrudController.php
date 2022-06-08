<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Controller\Admin\CategorieCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('categorie', 'categorie')
            ->setCrudController(CategorieCrudController::class),

            TextField::new('nom'),
            TextEditorField::new('description'),
            NumberField::new('Stock'),
            NumberField::new('Prix'),
            TextEditorField::new('histoire'),
            TextEditorField::new('utilisation'),
            ImageField::new('image')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            
                
           
        ];
    }
    
}
