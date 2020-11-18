<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Session;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionSumType;
use App\Form\QuestionMenuType;
use App\Form\QuestionSorpType;
use App\Form\QuestionDeathType;
use App\Form\QuestionNuggetsType;
use App\Repository\AnswerRepository;
use App\Repository\MenuRepository;
use App\Repository\CategoryRepository;
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
    public function addNuggets(Request $request, Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => 'Nuggets',
        ]);

        $answer1 = new Answer();
        $answer2 = new Answer();
        $answer3 = new Answer();
        $answer4 = new Answer();

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionNuggetsType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();            

            $question = $questionRepository->findOneBy([
                'id' => $question->getId(),
            ]);

            $answer1 = $formA1->getData();
            if ($answer1->getText() !== null) {
                $answer1->setCreatedAt(new \DateTime());
                $answer1->setAnswerOrder(1) ;
                $answer1->setSession($session);
                $answer1->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer1);
            }
            
            $answer2 = $formA2->getData();
            if ($answer2->getText() !== null) {
                $answer2->setCreatedAt(new \DateTime());
                $answer2->setAnswerOrder(2) ;
                $answer2->setSession($session);
                $answer2->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer2);
            }

            $answer3 = $formA3->getData();
            if ($answer3->getText() !== null) {
                $answer3->setCreatedAt(new \DateTime());
                $answer3->setAnswerOrder(3) ;
                $answer3->setSession($session);
                $answer3->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer3);
            }

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(4) ;
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'nuggetsActive' => 'active',
            ]);
        }

        return $this->render('question/add.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
        ]);

        
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/nuggets", name="nuggets_edit")
     */
    public function editNuggets(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository, AnswerRepository $answerRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Nuggets',
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $answer1 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer2 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 2,
        ]);
        $answer3 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 3,
        ]);
        $answer4 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 4,
        ]);

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionNuggetsType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);

            $answer1 = $formA1->getData();
            if ($answer1->getText() !== null) {
                $answer1->setCreatedAt(new \DateTime());
                $answer1->setAnswerOrder(1) ;
                $answer1->setSession($session);
                $answer1->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer1);
            }
            
            $answer2 = $formA2->getData();
            if ($answer2->getText() !== null) {
                $answer2->setCreatedAt(new \DateTime());
                $answer2->setAnswerOrder(2) ;
                $answer2->setSession($session);
                $answer2->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer2);
            }

            $answer3 = $formA3->getData();
            if ($answer3->getText() !== null) {
                $answer3->setCreatedAt(new \DateTime());
                $answer3->setAnswerOrder(3) ;
                $answer3->setSession($session);
                $answer3->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer3);
            }

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(4) ;
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'nuggetsActive' => 'active',
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
        ]);
    }

    /*****************************
     -------- SALT PEPPER --------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/sorp", name="sorp_add")
     */
    public function addSorp(Request $request, Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => 'Sel ou poivre',
        ]);

        $answer1 = new Answer();
        $answer2 = new Answer();
        $answer3 = new Answer();
        $answer4 = new Answer();

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionSorpType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->remove('isCorrect');
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();            

            $question = $questionRepository->findOneBy([
                'id' => $question->getId(),
            ]);

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(1) ;
                $answer4->setIsCorrect(true);
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'sorpActive' => 'active',
            ]);
        }

        return $this->render('question/add.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
            'onlyOne' => 'active',
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/sorp", name="sorp_edit")
     */
    public function editSorp(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository, AnswerRepository $answerRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Sel ou poivre',
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $answer1 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer2 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer3 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer4 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionSorpType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->remove('isCorrect');
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(1) ;
                $answer4->setIsCorrect(true);
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'sorpActive' => 'active',
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
            'onlyOne' => 'active',
        ]);
    }

    /*****************************
     ------------ MENUS ----------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/menu/{idMenu<\d+>}", name="menu_question_add")
     */
    public function addMenu(Request $request, Session $session = null, CategoryRepository $categoryRepository, $idMenu, MenuRepository $menuRepository, QuestionRepository $questionRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => "Menus",
        ]);
        $menu = $menuRepository->findOneBy([
            'id' => $idMenu,
        ]);

        $answer1 = new Answer();
        $answer2 = new Answer();
        $answer3 = new Answer();
        $answer4 = new Answer();

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionMenuType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);
            $question->setMenu($menu);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();            

            $question = $questionRepository->findOneBy([
                'id' => $question->getId(),
            ]);

            $answer1 = $formA1->getData();
            if ($answer1->getText() !== null) {
                $answer1->setCreatedAt(new \DateTime());
                $answer1->setAnswerOrder(1) ;
                $answer1->setSession($session);
                $answer1->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer1);
            }
            
            $answer2 = $formA2->getData();
            if ($answer2->getText() !== null) {
                $answer2->setCreatedAt(new \DateTime());
                $answer2->setAnswerOrder(2) ;
                $answer2->setSession($session);
                $answer2->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer2);
            }

            $answer3 = $formA3->getData();
            if ($answer3->getText() !== null) {
                $answer3->setCreatedAt(new \DateTime());
                $answer3->setAnswerOrder(3) ;
                $answer3->setSession($session);
                $answer3->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer3);
            }

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(4) ;
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'menusActive' => 'active',
            ]);
        }

        return $this->render('question/add.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/menu/{idMenu<\d+>}", name="menu_question_edit")
     */
    public function editMenu(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository, $idMenu, MenuRepository $menuRepository, AnswerRepository $answerRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
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

        $answer1 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer2 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 2,
        ]);
        $answer3 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 3,
        ]);
        $answer4 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 4,
        ]);

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionMenuType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);

            $answer1 = $formA1->getData();
            if ($answer1->getText() !== null) {
                $answer1->setCreatedAt(new \DateTime());
                $answer1->setAnswerOrder(1) ;
                $answer1->setSession($session);
                $answer1->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer1);
            }
            
            $answer2 = $formA2->getData();
            if ($answer2->getText() !== null) {
                $answer2->setCreatedAt(new \DateTime());
                $answer2->setAnswerOrder(2) ;
                $answer2->setSession($session);
                $answer2->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer2);
            }

            $answer3 = $formA3->getData();
            if ($answer3->getText() !== null) {
                $answer3->setCreatedAt(new \DateTime());
                $answer3->setAnswerOrder(3) ;
                $answer3->setSession($session);
                $answer3->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer3);
            }

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(4) ;
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'menusActive' => 'active',
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
        ]);
    }

    /*****************************
     ------------- SUM -----------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/sum", name="sum_add")
     */
    public function addSum(Request $request, Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => "L'addition",
        ]);

        $answer1 = new Answer();
        $answer2 = new Answer();
        $answer3 = new Answer();
        $answer4 = new Answer();

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionSumType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->remove('isCorrect');
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();            

            $question = $questionRepository->findOneBy([
                'id' => $question->getId(),
            ]);

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(1);
                $answer4->setIsCorrect(true);
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'sumActive' => 'active',
            ]);
        }

        return $this->render('question/add.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
            'onlyOne' => 'active',
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/sum", name="sum_edit")
     */
    public function editSum(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository, AnswerRepository $answerRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $category = $categoryRepository->findOneBy([
            'name' => "L'addition",
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $answer1 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer2 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer3 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer4 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionSumType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->remove('isCorrect');
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(1);
                $answer4->setIsCorrect(true);
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'sumActive' => 'active',
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
            'onlyOne' => 'active',
        ]);
    }

    /*****************************
     -------- DEATH MORBOL -------
     *****************************/
    
    /**
     * @Route("/session/{id<\d+>}/question/add/death", name="death_add")
     */
    public function addDeath(Request $request, Session $session = null, CategoryRepository $categoryRepository, QuestionRepository $questionRepository)
    {
        $question = new Question();

        $category = $categoryRepository->findOneBy([
            'name' => 'Morbol de la Mort',
        ]);

        $answer1 = new Answer();
        $answer2 = new Answer();
        $answer3 = new Answer();
        $answer4 = new Answer();

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionDeathType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->remove('isCorrect');
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();            

            $question = $questionRepository->findOneBy([
                'id' => $question->getId(),
            ]);

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(1);
                $answer4->setIsCorrect(true);
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'deathActive' => 'active',
            ]);
        }

        return $this->render('question/add.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
            'onlyOne' => 'active',
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}/death", name="death_edit")
     */
    public function editDeath(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, CategoryRepository $categoryRepository, AnswerRepository $answerRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $category = $categoryRepository->findOneBy([
            'name' => 'Morbol de la Mort',
        ]);
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $answer1 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer2 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer3 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);
        $answer4 = $answerRepository->findOneBy([
            'question' => $idQuestion,
            'answerOrder' => 1,
        ]);

        $questionForm = $this->get('form.factory')->createNamed('questionForm', QuestionDeathType::class, $question);
        $questionForm->handleRequest($request);

        $formA1 = $this->get('form.factory')->createNamed('formA1', AnswerType::class, $answer1);
        $formA1->handleRequest($request);

        $formA2 = $this->get('form.factory')->createNamed('formA2', AnswerType::class, $answer2);
        $formA2->handleRequest($request);

        $formA3 = $this->get('form.factory')->createNamed('formA3', AnswerType::class, $answer3);
        $formA3->handleRequest($request);

        $formA4 = $this->get('form.factory')->createNamed('formA4', AnswerType::class, $answer4);
        $formA4->remove('isCorrect');
        $formA4->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid()) {

            $question = $questionForm->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);
            $question->setCategory($category);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);

            $answer4 = $formA4->getData();
            if ($answer4->getText() !== null) {
                $answer4->setCreatedAt(new \DateTime());
                $answer4->setAnswerOrder(1);
                $answer4->setIsCorrect(true);
                $answer4->setSession($session);
                $answer4->setQuestion($question);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($answer4);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
                'deathActive' => 'active',
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'questionForm' => $questionForm->createView(),
            'formA1' => $formA1->createView(),
            'formA2' => $formA2->createView(),
            'formA3' => $formA3->createView(),
            'formA4' => $formA4->createView(),
            'onlyOne' => 'active',
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
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
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
