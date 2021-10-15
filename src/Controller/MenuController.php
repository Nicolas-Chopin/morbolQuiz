<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Entity\Session;
use App\Repository\CategoryRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    /**
     * @Route("/session/{id<\d+>}/menu/add", name="menu_add")
     */
    public function add(Request $request, Session $session = null, CategoryRepository $categoryRepository)
    {
        $menu = new Menu();

        $category = $categoryRepository->findOneBy([
            'name' => "Menus",
        ]);

        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $menu = $form->getData();
            $menu->setCreatedAt(new \DateTime());
            $menu->setSession($session);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash('success', 'Menu ajouté');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('menu/add.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/menu/edit/{idMenu<\d+>}", name="menu_edit")
     */
    public function edit(Request $request, Session $session = null, MenuRepository $menuRepository, $idMenu, CategoryRepository $categoryRepository)
    {
        //$this->denyAccessUnlessGranted('edit', $menu);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Ce menu n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $menu = $menuRepository->findOneBy([
            'id' => $idMenu,
        ]);
        $category = $categoryRepository->findOneBy([
            'name' => "Menus",
        ]);

        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $menu = $form->getData();
            $menu->setUpdatedAt(new \DateTime());
            $menu->setSession($session);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash('success', 'Menu modifié');

            return $this->redirectToRoute('session_overview', [
                'id' => $session->getId(),
            ]);
        }

        return $this->render('menu/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    /**
     * @Route("/session/{id<\d+>}/menu/delete/{idMenu<\d+>}", name="menu_delete")
     */
    public function delete(Session $session = null, MenuRepository $menuRepository, $idMenu)
    {
        //$this->denyAccessUnlessGranted('delete', $menu);
        
        if ($session === null) {
            // 404 ?
            throw $this->createNotFoundException('Ce menu n\'existe pas.');
        }
        // Forbidden if you're not the owner
        if ($session->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $menu = $menuRepository->findOneBy([
            'id' => $idMenu,
        ]);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($menu);
        $entityManager->flush();

        $this->addFlash('success', 'Menu supprimé');

        return $this->redirectToRoute('session_overview', [
            'id' => $session->getId(),
        ]);
    }
}
