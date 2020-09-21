<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = TextField::new('name', 'Nom'); 
        $created = DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm();

        if (Crud::PAGE_NEW === $pageName) {
            return [$name];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name];
        } else {
            return [$id, $name, $created, $updated];
        };
    }
    
}
