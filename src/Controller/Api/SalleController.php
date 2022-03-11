<?php

namespace App\Controller\Api;

use App\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api', name: 'api_salles_', methods: ['GET'])]
class SalleController extends AbstractController
{
    #[Route('/salles', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $salles = $em->getRepository(Salle::class)->findAll();
        return $this->json($salles, 200);
    }
}
