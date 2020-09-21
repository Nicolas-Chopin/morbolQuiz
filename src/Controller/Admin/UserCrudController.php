<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $username = TextField::new('username', 'Identifiant'); 
        $email = EmailField::new('email', 'Mail');
        $isEmailCheck = BooleanField::new('isEmailCheck', 'Mail vérifié');
        $isActive = BooleanField::new('isActive', 'Actif');
        $firstname = TextField::new('firstname', 'Prenom'); 
        $lastname = TextField::new('lastname', 'Nom'); 

        $userRole = AssociationField::new('userRole', 'Rôle');

        $created = DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm();

        
        if (Crud::PAGE_NEW === $pageName) {
            return [$username, $lastname, $firstname, $email, $isEmailCheck, $isActive, $userRole];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$username, $lastname, $firstname, $email, $isEmailCheck, $isActive, $userRole];
        } else {
            return [$id, $username, $email, $isEmailCheck, $isActive, $userRole, $created, $updated];
        };
    }
}
