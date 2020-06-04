<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\CategoryRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();

        return $this->render('main/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}", name="session_show", methods={"GET"})
     */
    public function selectedSession(Session $session = null, CategoryRepository $categoryRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $categories = $categoryRepository->findAllOrderId();

        return $this->render('main/session_show.html.twig', [
            'categories' => $categories,
            'session' => $session,
        ]);
    }
}
