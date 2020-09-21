<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Partie')
            ->setEntityLabelInPlural('Parties')
            ->setDateTimeFormat('dd MMM y, HH:mm:ss')
            ->setDefaultSort(['id' => 'ASC'])
            ->setPageTitle('new', 'Ajouter une partie')
            ->setPageTitle('edit', 'Editer une partie')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = TextField::new('name', 'Nom'); 
        $created = DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm();
        $sorpname = TextField::new('sorpname', 'Thème S-ou-P'); 
        $sumname = TextField::new('sumname', 'Thème addition'); 
        $aTeamName = TextField::new('aTeamName', 'Nom équipe A');
        $bTeamName = TextField::new('bTeamName', 'Nom équipe B');
        $aTeamScore = IntegerField::new('aTeamScore', 'Score équipe A');
        $bTeamScore = IntegerField::new('bTeamScore', 'Score équipe B');
        $aTeamImgUrl = UrlField::new('aTeamImgUrl', 'Url image équipe A');
        $bTeamImgUrl = UrlField::new('bTeamImgUrl', 'Url image équipe B');

        if (Crud::PAGE_NEW === $pageName) {
            return [$name, $sorpname, $sumname, $aTeamName, $bTeamName, $aTeamImgUrl, $bTeamImgUrl];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $sorpname, $sumname, $aTeamName, $bTeamName, $aTeamScore, $bTeamScore, $aTeamImgUrl, $bTeamImgUrl];
        } else {
            return [$id, $name, $sorpname, $sumname, $aTeamName, $bTeamName, $created, $updated];
        };
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une partie');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Editer');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Ajouter puis en créer une autre');
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
