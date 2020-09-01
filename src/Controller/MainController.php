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
        
        $categoryOne = $categories[0];
        $categoryTwo = $categories[1];
        $categoryThree = $categories[2];
        $categoryFour = $categories[3];
        $categoryFive = $categories[4];

        $questionNumber = 1;

        return $this->render('user/session_show.html.twig', [
            'nuggets' => $categoryOne,
            'salt' => $categoryTwo,
            'menus' => $categoryThree,
            'sum' => $categoryFour,
            'deathMorbol' => $categoryFive,
            'questionNumber' => $questionNumber,
            'session' => $session,
        ]);
    }
}
