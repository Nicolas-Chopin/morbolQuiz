<?php

namespace App\Controller\Api;

use App\Entity\Session;
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
}
