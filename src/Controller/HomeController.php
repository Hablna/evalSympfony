<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueRepositoryType;
use App\Repository\MarqueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MarqueRepository $repo): Response
    {
        $marque=$repo->findAll();
        return $this->render('home/index.html.twig', [
            'marques' => $marque,
        ]);
    }

    #[Route('/marque/ajouter', name: 'app_ajouter_marque')]
    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueRepositoryType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute("app_home");
        }
        return $this->render('home/ajouter.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    #[Route('/marque/modifier/{id}', name: 'app_modifier_marque')]
    public function modifier($id, Request $request, ManagerRegistry $doctrine, MarqueRepository $repo): Response
    {
        $marque = $repo->find($id);
        $form = $this->createForm(MarqueRepositoryType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute("app_home");
        }
        return $this->render('home/modifier.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    #[Route('/marque/supprimer/{id}', name: 'app_supprimer_marque')]
    public function supprimer($id, MarqueRepository $repo, ManagerRegistry $doctrine): Response
    {
        $marque = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($marque);
        $em->flush();
        return $this->redirectToRoute("app_home");
    }
}
