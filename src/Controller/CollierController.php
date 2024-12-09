<?php

namespace App\Controller;

use App\Entity\Collier;
use App\Form\CollierType;
use App\Repository\CollierRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CollierController extends AbstractController
{
    #[Route('/collier', name: 'app_collier')]
    public function index(CollierRepository $repo): Response
    {
        $collier=$repo->findAll();
        return $this->render('collier/index.html.twig', [
            'collier' => $collier,
        ]);
    }

    #[Route('/collier/ajouter', name: 'app_ajouter_collier')]
    public function ajouter(Request $request, ManagerRegistry $registry){
        $collier = new Collier();
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($collier);
            $em->flush();
            return $this->redirectToRoute("app_collier");
        }
        return $this->render('collier/ajouter.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    #[Route('/collier/modifier/{id}', name: 'app_modifier_collier')]
    public function modifier($id, Request $request, ManagerRegistry $registry, CollierRepository $repo): Response
    {
        $collier = $repo->find($id);
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($collier);
            $em->flush();
            return $this->redirectToRoute("app_collier");
        }
        return $this->render('collier/modifier.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }
}
