<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudFormType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
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
        $created = DatetimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateField::new('updatedAt', 'Modifié le')->hideOnForm();

        if (Crud::PAGE_NEW === $pageName) {
            return [$name, $created];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $updated];
        } else {
            return [$id, $name, $created, $updated];
        };
    }
    
}
