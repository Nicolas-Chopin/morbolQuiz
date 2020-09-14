<?php

namespace App\Controller\Api;

use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiScoreController extends AbstractController
{
    /**
     * Add a point to A Team 
     * 
     * @Route("/api/session/{id<\d+>}/plusonea", name="api_plusonea", methods={"POST"})
     */
    public function plusOneA($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getATeamScore();
        $scoreA = $currentSession->setATeamScore($currentScore+1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreA);
        $entityManager->flush($scoreA);

        return $this->json('1 point gagné', Response::HTTP_OK);       
    }

    /**
     * Add 3 points to A Team 
     * 
     * @Route("/api/session/{id<\d+>}/plusthreea", name="api_plusthreea", methods={"POST"})
     */
    public function plusThreeA($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getATeamScore();
        $scoreA = $currentSession->setATeamScore($currentScore+3);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreA);
        $entityManager->flush($scoreA);

        return $this->json('3 points gagnés', Response::HTTP_OK);       
    }

    /**
     * Add a point to B Team 
     * 
     * @Route("/api/session/{id<\d+>}/plusoneb", name="api_plusoneb", methods={"POST"})
     */
    public function plusOneB($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getBTeamScore();
        $scoreB = $currentSession->setBTeamScore($currentScore+1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreB);
        $entityManager->flush($scoreB);

        return $this->json('1 point gagné', Response::HTTP_OK);       
    }

    /**
     * Add 3 points to B Team 
     * 
     * @Route("/api/session/{id<\d+>}/plusthreeb", name="api_plusthreeb", methods={"POST"})
     */
    public function plusThreeB($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getBTeamScore();
        $scoreB = $currentSession->setBTeamScore($currentScore+3);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreB);
        $entityManager->flush($scoreB);

        return $this->json('3 points gagnés', Response::HTTP_OK);       
    }

    /**
     * Minus a point to A Team 
     * 
     * @Route("/api/session/{id<\d+>}/minusonea", name="api_minusonea", methods={"POST"})
     */
    public function minusOneA($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getATeamScore();
        $scoreA = $currentSession->setATeamScore($currentScore-1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreA);
        $entityManager->flush($scoreA);

        return $this->json('1 point perdu', Response::HTTP_OK);       
    }

    /**
     * Minus 3 points to A Team 
     * 
     * @Route("/api/session/{id<\d+>}/minusthreea", name="api_minusthreea", methods={"POST"})
     */
    public function minusThreeA($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getATeamScore();
        $scoreA = $currentSession->setATeamScore($currentScore-3);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreA);
        $entityManager->flush($scoreA);

        return $this->json('-3 points', Response::HTTP_OK);       
    }

    /**
     * Minus a point to B Team 
     * 
     * @Route("/api/session/{id<\d+>}/minusoneb", name="api_minusoneb", methods={"POST"})
     */
    public function minusOneB($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getBTeamScore();
        $scoreB = $currentSession->setBTeamScore($currentScore-1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreB);
        $entityManager->flush($scoreB);

        return $this->json('1 point perdu', Response::HTTP_OK);       
    }

    /**
     * Minus 3 points to B Team 
     * 
     * @Route("/api/session/{id<\d+>}/minusthreeb", name="api_minusthreeb", methods={"POST"})
     */
    public function minusThreeB($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $currentScore = $currentSession->getBTeamScore();
        $scoreB = $currentSession->setBTeamScore($currentScore-3);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreB);
        $entityManager->flush($scoreB);

        return $this->json('-3 points', Response::HTTP_OK);       
    }

    /**
     * Reset A Team's score
     * 
     * @Route("/api/session/{id<\d+>}/reseta", name="api_reseta", methods={"POST"})
     */
    public function resetA($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $scoreA = $currentSession->setATeamScore(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreA);
        $entityManager->flush($scoreA);

        return $this->json('Reset des points', Response::HTTP_OK);       
    }

    /**
     * Reset B Team's score
     * 
     * @Route("/api/session/{id<\d+>}/resetb", name="api_resetb", methods={"POST"})
     */
    public function resetB($id, SessionRepository $sessionRepository)
    {
        $currentSession = $sessionRepository->findOneBy(['id' => $id]);

        if ($currentSession === null) {
            return $this->json(['message' => 'Session non existante.'], Response::HTTP_NOT_FOUND);
        }
        
        $scoreB = $currentSession->setBTeamScore(0);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($scoreB);
        $entityManager->flush($scoreB);

        return $this->json('Reset des points', Response::HTTP_OK);       
    }
}
