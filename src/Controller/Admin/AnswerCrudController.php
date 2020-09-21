<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Answer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Réponse')
            ->setEntityLabelInPlural('Réponses')
            ->setDateTimeFormat('dd MMM y, HH:mm:ss')
            ->setDefaultSort(['id' => 'ASC'])
            ->setPageTitle('new', 'Ajouter une réponse')
            ->setPageTitle('edit', 'Editer une réponse')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $text = TextField::new('text', 'Texte'); 
        $answerOrder = IntegerField::new('answerOrder', 'Position de la réponse');
        $isCorrect = BooleanField::new('isCorrect', 'Réponse correcte');

        $session = AssociationField::new('session', 'Partie');
        $question = AssociationField::new('question', 'Question');

        $created = DateTimeField::new('createdAt', 'Créé le')->hideOnForm();
        $updated = DateTimeField::new('updatedAt', 'Modifié le')->hideOnForm();

        
        if (Crud::PAGE_NEW === $pageName) {
            return [$text, $answerOrder, $isCorrect, $session, $question];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$text, $answerOrder, $isCorrect, $session, $question];
        } else {
            return [$id, $text, $answerOrder, $isCorrect, $session, $question, $created, $updated];
        };
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une réponse');
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
