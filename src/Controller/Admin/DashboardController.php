<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Session;
use App\Entity\Category;
use App\Entity\Question;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Morbol Quiz');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');


        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Rôles', 'fa fa-user-tag', Role::class);


        yield MenuItem::section('Epreuves');
        yield MenuItem::linkToCrud('Epreuves', 'fa fa-clipboard-list', Category::class);


        yield MenuItem::section('Parties');
        yield MenuItem::linkToCrud('Parties', 'fa fa-dice-d20', Session::class);
        yield MenuItem::linkToCrud('Menus', 'fa fa-book-reader', Menu::class);
        yield MenuItem::linkToCrud('Questions', 'fa fa-question', Question::class);
        yield MenuItem::linkToCrud('Réponses', 'fa fa-check', Answer::class);


        yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }
}
