<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    #[Route('/api/cours', name: 'app_api_cours')]
    public function index(): Response
    {
        return $this->render('api/cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
}
