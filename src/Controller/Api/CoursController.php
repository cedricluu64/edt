<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cours;

class CoursController extends AbstractController
{
    #[Route('/api/cours', name: 'api_cours_list', methods: ['GET'])]
    public function getAllCours(EntityManagerInterface $em): JsonResponse
    {
        $cours = $em->getRepository(Cours::class)->findAll();
        return $this->json($cours, 200);
    }
}
