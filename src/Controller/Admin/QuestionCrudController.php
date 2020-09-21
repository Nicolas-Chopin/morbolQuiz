<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Question')
            ->setEntityLabelInPlural('Questions')
            ->setDateTimeFormat('dd MMM y, HH:mm:ss')
            ->setDefaultSort(['id' => 'ASC'])
            ->setPageTitle('new', 'Ajouter une question')
            ->setPageTitle('edit', 'Editer une question')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $text = TextField::new('text', 'Texte'); 
        $created = DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm();
        
        $session = AssociationField::new('session', 'Partie');
        $category = AssociationField::new('category', 'Epreuve');

        $orderInNuggets = IntegerField::new('orderInNuggets', 'Position Nuggets');
        $orderInSaltpepper = IntegerField::new('orderInSaltpepper', 'Position S-ou-P');
        $menu = AssociationField::new('menu', 'Menu');
        $orderInMenu = IntegerField::new('orderInMenu', 'Position Menu');
        $orderInSum = IntegerField::new('orderInSum', 'Position Addition');
        $orderInDeathquiz = IntegerField::new('orderInDeathquiz', 'Position Morbol de la mort');
      
        if (Crud::PAGE_NEW === $pageName) {
            return [$text, $session, $category, $orderInNuggets, $orderInSaltpepper, $menu, $orderInMenu, $orderInSum, $orderInDeathquiz];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$text, $session, $category, $orderInNuggets, $orderInSaltpepper, $menu, $orderInMenu, $orderInSum, $orderInDeathquiz];
        } else {
            return [$id, $text, $session, $category, $menu, $created, $updated];
        };
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une question');
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
