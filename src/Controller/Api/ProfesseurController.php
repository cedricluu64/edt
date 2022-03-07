<?php

namespace App\Controller\Api;

use App\Entity\Avis;
use App\Entity\Professeur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/professeurs', name: 'api_professeurs_')]
class ProfesseurController extends AbstractController
{

    use ControllerHelpers;
    
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(ProfesseurRepository $repo): JsonResponse
    {
        $professeurs=$repo->findAll();
        /** 
        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent(json_encode(array_map(fn ($professeur) => $professeur->toArray(), $professeurs)));
        $response->headers->set("Content-Type","application/json");
        */

        return $this->json($professeurs,200);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Professeur $professeur = null): JsonResponse
    {
        if( is_null($professeur)){
            return $this->json(["message"=>"Ce professeur est introuvable"],404);
        }
        return $this->json($professeur,200);
    }

    #[Route('/{id}/avis', name: 'list_avis', methods: ['GET'])]
    public function listAvis(Professeur $professeur = null): JsonResponse
    {
        if( is_null($professeur)){
            return $this->json(["message"=>"Ce professeur est introuvable"],404);
        }
        return $this->json($professeur->getLesAvis()->toArray(),200);
    }

    #[Route('/{id}/avis', name: 'ajouter_avis', methods: ['POST'])]
    #[UniqueEntity(fields:["emailEtudiant", 'professeur'], errorPath: "emailEtudiant", message: "Cet étudiant a déjà noté ce professeur.")]
    public function ajouterAvis(Professeur $professeur = null, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        if( is_null($professeur)){
            return $this->json(["message"=>"Ce professeur est introuvable"],404);
        }
        $data = json_decode($request->getContent(), true);


        $avis = (new Avis)->fromArray($data)->setProfesseur($professeur);

        $error = $validator->validate($avis);

        if($error->count() > 0){
            return $this->json(["Message" => $this->formatErrors($error)], 400);
        }

        $em->persist($avis);
        $em->flush();
        return $this->json($avis, 201);
    }

    #[Route('/avis/{id}', name: 'suppr_avis', methods: ['DELETE'])]
    public function supprimerAvis(Avis $avis = null, EntityManagerInterface $em): JsonResponse
    {
        if( is_null($avis)){
            return $this->json(["message"=>"Cet avis est introuvable"],404);
        }

        $em->remove($avis);
        $em->flush();
        return $this->json([],204);
    }

    #[Route('/avis/{id}', name: 'edit_avis', methods: ['PATCH'])]
    public function editAvis(Avis $avis = null, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        if( is_null($avis)){
            return $this->json(["message"=>"Cet avis est introuvable"],404);
        }

        $data = json_decode($request->getContent(), true);
        
        $message= $avis->updateFromArray($data);
         
        $error = $validator->validate($avis);

        if($error->count() > 0){
            return $this->json(["Message" => $this->formatErrors($error)], 400);
        }

        $em->persist($avis);
        $em->flush();


        
        return $this->json(["Notification"=>$message,"avis voulu" => $data, "avis résultant" => $avis],200);
    }



}
