<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cours;
use App\Entity\Avis;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cours', name: 'api_cours_')]
class CoursController extends AbstractController
{
    use ControllerHelpers;

    #[Route('/', name: 'list', methods: ['GET'])]
    public function getAllCours(EntityManagerInterface $em): JsonResponse
    {
        $cours = $em->getRepository(Cours::class)->findAll();
        return $this->json($cours, 200);
    }

    #[Route('/{id}/avis', name: 'ajouter_avis', methods: ['POST'])]
    #[UniqueEntity(fields:["emailEtudiant", 'cours'], errorPath: "emailEtudiant", message: "Cet étudiant a déjà noté ce cours.")]
    public function ajouterAvis(Cours $cours = null, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        if( is_null($cours)){
            return $this->json(["message"=>"Ce professeur est introuvable"],404);
        }
        $data = json_decode($request->getContent(), true);


        $avis = (new Avis)->fromArray($data)->setCours($cours);

        $error = $validator->validate($avis);

        if($error->count() > 0){
            return $this->json(["Message" => $this->formatErrors($error)], 400);
        }

        $em->persist($avis);
        $em->flush();
        return $this->json($avis, 201);
    }
}
