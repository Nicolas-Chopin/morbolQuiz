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
     * @Route("/session/{id<\d+>}/overview", name="session_overview", methods={"GET"})
     */
    public function sessionOverview($id, Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository, MenuRepository $menuRepository, AnswerRepository $answerRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $categories = $categoryRepository->findAllOrderId();
        
        $categoryOne = $categories[0];
        $categoryTwo = $categories[1];
        $categoryThree = $categories[2];
        $categoryFour = $categories[3];
        $categoryFive = $categories[4];

        $nuggetsQuestions = $questionRepository->findBy([
            'category' => $categories[0],
            'session' => $session,
        ],['orderInNuggets' => 'ASC']);
        $sorpQuestions = $questionRepository->findBy([
            'category' => $categories[1],
            'session' => $session,
        ],['orderInSaltpepper' => 'ASC']);
        $menusQuestions = $questionRepository->findBy([
            'category' => $categories[2],
            'session' => $session,
        ],['orderInMenu' => 'ASC']);
        $sumQuestions = $questionRepository->findBy([
            'category' => $categories[3],
            'session' => $session,
        ],['orderInSum' => 'ASC']);
        $deathQuestions = $questionRepository->findBy([
            'category' => $categories[4],
            'session' => $session,
        ],['orderInDeathquiz' => 'ASC']);

        $menusNames = $menuRepository->findBy([
            'session' => $session,
        ],['menuOrder' => 'ASC']);

        return $this->render('session/overview.html.twig', [
            'nuggets' => $categoryOne,
            'salt' => $categoryTwo,
            'menus' => $categoryThree,
            'sum' => $categoryFour,
            'deathMorbol' => $categoryFive,
            'session' => $session,
            'nuggetsQuestions' => $nuggetsQuestions,
            'sorpQuestions' => $sorpQuestions,
            'menusNames' => $menusNames,
            'menusQuestions' => $menusQuestions,
            'sumQuestions' => $sumQuestions,
            'deathQuestions' => $deathQuestions,
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

        return $this->render('session/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/edit/{id<\d+>}", name="session_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Session $session = null)
    {
        //$this->denyAccessUnlessGranted('edit', $session);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette partie n\'existe pas.');
        }

        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $session->setUpdatedAt(new \DateTime());
            $session->setUser($session->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            $this->addFlash('success', 'Session modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('session/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/delete/{id<\d+>}", name="session_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Session $session = null)
    {
        //$this->denyAccessUnlessGranted('delete', $session);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette partie n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($session);
        $entityManager->flush();

        $this->addFlash('success', 'Session supprimée');

        return $this->redirectToRoute('user_profile');
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
