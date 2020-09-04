<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\MenuRepository;
use App\Repository\AnswerRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{
    /**
     * @Route("/session/{id<\d+>}", name="session_show", methods={"GET"})
     */
    public function selectedSession($id, Session $session = null, CategoryRepository $categoryRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $categories = $categoryRepository->findAllOrderId();
        
        $categoryOne = $categories[0];
        $categoryTwo = $categories[1];
        $categoryThree = $categories[2];
        $categoryFour = $categories[3];
        $categoryFive = $categories[4];

        $questionNumber = 1;

        return $this->render('game/session_show.html.twig', [
            'nuggets' => $categoryOne,
            'salt' => $categoryTwo,
            'menus' => $categoryThree,
            'sum' => $categoryFour,
            'deathMorbol' => $categoryFive,
            'questionNumber' => $questionNumber,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/session/add", name="session_add", methods={"GET", "POST"})
     */
    public function add(Request $request)
    {
        $session = new Session();

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $session->setCreatedAt(new \DateTime());
            $session->setATeamScore(0);
            $session->setBTeamScore(0);
            $session->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            $this->addFlash('success', 'Session ajoutée');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
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
