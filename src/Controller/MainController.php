<?php

namespace App\Controller;

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
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contact()
    {
        return $this->render('main/contact.html.twig');
    }

    /**
     * @Route("/legal-mentions", name="legal-mentions", methods={"GET"})
     */
    public function legalMentions()
    {
        return $this->render('main/legal-mentions.html.twig');
    }

    /**
     * @Route("/patchnotes", name="patchnotes", methods={"GET"})
     */
    public function patchnotes()
    {
        return $this->render('main/patchnotes.html.twig');
    }
}
