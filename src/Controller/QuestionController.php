<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/session/{id<\d+>}/question/add", name="question_add")
     */
    public function add(Request $request, Session $session = null)
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setCreatedAt(new \DateTime());
            $question->setSession($session);

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
     * @Route("/session/{id<\d+>}/question/edit/{idQuestion<\d+>}", name="question_edit")
     */
    public function edit(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion)
    {
        //$this->denyAccessUnlessGranted('edit', $question);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette question n\'existe pas.');
        }
        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();
            $question->setUpdatedAt(new \DateTime());
            $question->setSession($session);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

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
