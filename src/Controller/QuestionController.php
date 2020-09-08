<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Form\QuestionSumType;
use App\Form\QuestionMenuType;
use App\Form\QuestionSorpType;
use App\Form\QuestionDeathType;
use App\Form\QuestionNuggetsType;
use App\Repository\CategoryRepository;
use App\Repository\MenuRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /*****************************
     ---------- NUGGETS ----------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/nuggets", name="nuggets_add")
     */
    public function addNuggets(Request $request, Session $session = null, CategoryRepository $categoryRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => 'Nuggets',
        ]);

        $form = $this->createForm(QuestionNuggetsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/nuggets", name="nuggets_edit")
     */
    public function editNuggets(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Nuggets',
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $form = $this->createForm(QuestionNuggetsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /*****************************
     -------- SALT PEPPER --------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/sorp", name="sorp_add")
     */
    public function addSorp(Request $request, Session $session = null, CategoryRepository $categoryRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => 'Sel ou poivre',
        ]);

        $form = $this->createForm(QuestionSorpType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/addSorp.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/sorp", name="sorp_edit")
     */
    public function editSorp(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Sel ou poivre',
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $form = $this->createForm(QuestionSorpType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /*****************************
     ------------ MENUS ----------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/menu/{idMenu<\d+>}", name="menu_question_add")
     */
    public function addMenu(Request $request, Session $session = null, CategoryRepository $categoryRepository, $idMenu, MenuRepository $menuRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => "Menus",
        ]);
        $menu = $menuRepository->findOneBy([
            'id' => $idMenu,
        ]);

        $form = $this->createForm(QuestionMenuType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);
            $question->setMenu($menu);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/menu/{idMenu<\d+>}", name="menu_question_edit")
     */
    public function editMenu(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository, $idMenu, MenuRepository $menuRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => "Menus",
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);
        $menu = $menuRepository->findOneBy([
            'id' => $idMenu,
        ]);

        $form = $this->createForm(QuestionMenuType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);
            $question->setMenu($menu);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /*****************************
     ------------- SUM -----------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/sum", name="sum_add")
     */
    public function addSum(Request $request, Session $session = null, CategoryRepository $categoryRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => "L'addition",
        ]);

        $form = $this->createForm(QuestionSumType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/sum", name="sum_edit")
     */
    public function editSum(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => "L'addition",
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $form = $this->createForm(QuestionSumType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /*****************************
     -------- DEATH MORBOL -------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/death", name="death_add")
     */
    public function addDeath(Request $request, Session $session = null, CategoryRepository $categoryRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => 'Morbol de la Mort',
        ]);

        $form = $this->createForm(QuestionDeathType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/death", name="death_edit")
     */
    public function editDeath(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Morbol de la Mort',
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $form = $this->createForm(QuestionDeathType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /*****************************
     ------- DELETE METHOD -------
     *****************************/

    /**
     * @Route("/session/{id<\d+>}/question/delete/{idQuestion<\d+>}", name="question_delete")
     */
    public function delete(Session $session = null, QuestionRepository $questionRepository, $idQuestion)
    {
        //$this->denyAccessUnlessGranted('delete', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($question);
        $entityManager->flush();

        $this->addFlash('success', 'Question supprimée');

        return $this->redirectToRoute('session_overview', [
            'id' => $session->getId(),
        ]);
    }
}
