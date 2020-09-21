<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class AnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Answer::class;
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
}
