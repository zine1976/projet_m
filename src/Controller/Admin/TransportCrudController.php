<?php

namespace App\Controller\Admin;

use App\Entity\Transport;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TransportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transport::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('nom'),
            TextEditorField::new('detail'),
            NumberField::new('prix'),

        ];
    }
 
}
