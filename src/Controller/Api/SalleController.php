<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SalleController extends AbstractController
{
    #[Route('/api/salles', name: 'api_salles_list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $salles = $em->getRepository(Salle::class)->findAll();
        return $this->json($salles, 200);
    }
}
