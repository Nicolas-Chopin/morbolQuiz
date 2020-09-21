<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
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
    
}
