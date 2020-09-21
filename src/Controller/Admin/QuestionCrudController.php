<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
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
}
