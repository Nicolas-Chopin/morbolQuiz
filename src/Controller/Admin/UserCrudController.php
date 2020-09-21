<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setDateTimeFormat('dd MMM y, HH:mm:ss')
            ->setDefaultSort(['id' => 'ASC'])
            ->setPageTitle('new', 'Ajouter un utilisateur')
            ->setPageTitle('edit', 'Editer un utilisateur')
        ;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter un utilisateur');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Editer');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Ajouter puis en créer un autre');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel("Sauvegarder et continuer l'édition");
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Sauvegarder');
            })
        ;
    }
}
