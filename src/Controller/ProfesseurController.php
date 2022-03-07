<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Professeur;
use App\Repository\ProfesseurRepository;
use App\Form\ProfesseurType;
use Doctrine\ORM\EntityManagerInterface;



#[Route('/professeurs', name:'professeur_', methods:['GET'])]

class ProfesseurController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(ProfesseurRepository $repository): Response
    {
        $professeurs = $repository->findAll();
        return $this->render('professeurs/index.html.twig', ['professeurs'=> $professeurs]);
    }


    #[Route('/create', name:'create', methods:['POST'])]
    public function create(Request $request, EntityManagerInterface $doctrine): Response{
        $professeur = new Professeur;
        $form = $this->createForm(ProfesseurType::class, $professeur);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
            $professeur = $form->getData();

            $doctrine->persist($professeur);
            $doctrine->flush();

            return $this->redirectToRoute('professeur_list');
        }
        return $this->render('professeurs/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/edit', name:'edit', methods:['POST'])]
    public function edit(Professeur $professeur,Request $request, EntityManagerInterface $doctrine): Response{

        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
            $professeur = $form->getData();

            $doctrine->persist($professeur);
            $doctrine->flush();

            return $this->redirectToRoute('professeur_list');
        }
        return $this->render('professeurs/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/delete', name:'delete')]
    public function delete(Professeur $professeur, EntityManagerInterface $em): Response{

        $em->remove($professeur);
        $em->flush();

        return $this->redirectToRoute('professeur_list');
    }
}
