<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\AnswerRepository;
use App\Repository\CategoryRepository;
use App\Repository\MenuRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{
    /**
     * @Route("/session/{id<\d+>}/nuggets/{orderInNuggets<\d+>}", name="nuggets")
     */
    public function nuggets(Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository, $orderInNuggets)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Nuggets',
        ]);
        
        $question = $questionRepository->findOneBy([
            'session' => $session,
            'category' => $category,
            'orderInNuggets' => $orderInNuggets,
        ]);

        $arrayAnswers = $answerRepository->findBy([
            'question' => $question,
        ], 
        ['answerOrder' => 'ASC']
        );
        
        return $this->render('game/nuggets.html.twig', [
            'question' => $question,
            'session' => $session,
            'category' => $category,
            'answers' => $arrayAnswers,
            'orderInNuggets' => $orderInNuggets,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/sorp", name="sorp")
     */
    public function sorp(Session $session = null, CategoryRepository $categoryRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Sel ou poivre',
        ]);
        
        return $this->render('game/sorp.html.twig', [
            'session' => $session,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/menus", name="menus")
     */
    public function menus(Session $session = null, CategoryRepository $categoryRepository, MenuRepository $menuRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => "Menus",
        ]);

        $menus = $menuRepository->findBy([
            'session' => $session,
        ],
        ['menuOrder' => 'ASC']
        );

        $menuNumber = 1;

        $menuOne = $menus[0];
        $menuTwo = $menus[1];
        $menuThree = $menus[2];
        
        return $this->render('game/menus.html.twig', [
            'session' => $session,
            'category' => $category,
            'menuOne' => $menuOne,
            'menuTwo' => $menuTwo,
            'menuThree' => $menuThree,
            'menuNumber' => $menuNumber,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/menus/{orderInMenu<\d+>}", name="menu_show")
     */
    public function selectedMenu(Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository, AnswerRepository $answerRepository, $orderInMenu)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Menus',
        ]);
        
        $question = $questionRepository->findOneBy([
            'session' => $session,
            'category' => $category,
            'orderInMenu' => $orderInMenu,
        ]);

        $arrayAnswers = $answerRepository->findBy([
            'question' => $question,
        ], 
        ['answerOrder' => 'ASC']
        );
        
        return $this->render('game/menu_show.html.twig', [
            'question' => $question,
            'session' => $session,
            'category' => $category,
            'answers' => $arrayAnswers,
            'orderInMenu' => $orderInMenu,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/sum", name="sum")
     */
    public function sum(Session $session = null, CategoryRepository $categoryRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => "L'addition",
        ]);
        
        return $this->render('game/sum.html.twig', [
            'session' => $session,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/deathmorbol", name="death_morbol")
     */
    public function deathMorbol(Session $session = null, CategoryRepository $categoryRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => "Morbol de la Mort",
        ]);
        
        return $this->render('game/death_morbol.html.twig', [
            'session' => $session,
            'category' => $category,
        ]);
    }
}
