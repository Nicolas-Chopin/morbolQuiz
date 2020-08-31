<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/session/{id<\d+>}", name="session_show", methods={"GET"})
     */
    public function selectedSession($id, Session $session = null, CategoryRepository $categoryRepository)
    {
        if ($session === null) {
            throw $this->createNotFoundException('Session introuvable.');
        }

        $categories = $categoryRepository->findAllOrderId();

        return $this->render('user/session_show.html.twig', [
            'categories' => $categories,
            'session' => $session,
        ]);
    }
}
