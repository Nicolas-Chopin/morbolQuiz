<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = TextField::new('name', 'Nom'); 
        $created = DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm();
        $menuOrder = IntegerField::new('menuOrder', 'Position du menu');
        $session = AssociationField::new('session', 'Partie');

        if (Crud::PAGE_NEW === $pageName) {
            return [$name, $menuOrder, $session];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $menuOrder, $session];
        } else {
            return [$id, $name, $session, $menuOrder, $created, $updated];
        };
    }
}
