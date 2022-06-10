<?php

namespace App\Controller\Admin;

use App\Entity\Adressefact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdressefactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adressefact::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
