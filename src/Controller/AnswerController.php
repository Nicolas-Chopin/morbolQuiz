<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Session;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnswerController extends AbstractController
{
    /**
     * @Route("/session/{id<\d+>}/question/{idQuestion<\d+>}/answer/add", name="answer_add")
     */
    public function add(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion)
    {
        $answer = new Answer();

        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $answer = $form->getData();
            $answer->setCreatedAt(new \DateTime());
            $answer->setSession($session);
            $answer->setQuestion($question);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();

            $this->addFlash('success', 'Réponse ajoutée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('answer/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/{idQuestion<\d+>}/answer/{idAnswer<\d+>}/edit", name="answer_edit")
     */
    public function edit(Request $request, Session $session = null, QuestionRepository $questionRepository, $idQuestion, AnswerRepository $answerRepository, $idAnswer)
    {
        //$this->denyAccessUnlessGranted('edit', $answer);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette réponse n\'existe pas.');
        }

        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);
        $answer = $answerRepository->findOneBy([
            'id' => $idAnswer,
        ]);

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $answer = $form->getData();
            $answer->setUpdatedAt(new \DateTime());
            $answer->setSession($session);
            $answer->setQuestion($question);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();

            $this->addFlash('success', 'Réponse modifiée');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('answer/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/question/{idQuestion<\d+>}/answer/{idAnswer<\d+>}/delete", name="answer_delete")
     */
    public function delete(Session $session = null, QuestionRepository $questionRepository, $idQuestion, AnswerRepository $answerRepository, $idAnswer)
    {
        //$this->denyAccessUnlessGranted('delete', $answer);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Cette réponse n\'existe pas.');
        }

        $question = $questionRepository->findOneBy([
            'id' => $idQuestion,
        ]);
        $answer = $answerRepository->findOneBy([
            'id' => $idAnswer,
        ]);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($answer);
        $entityManager->flush();

        $this->addFlash('success', 'Réponse supprimée');

        return $this->redirectToRoute('session_overview', [
            'id' => $session->getId(),
        ]);
    }
}
