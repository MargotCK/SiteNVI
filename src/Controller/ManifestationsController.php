<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ManifestationsController extends AbstractController
{
    #[Route('/manifestations', name: 'app_manifestations')]
    public function index(): Response
    {
        return $this->render('manifestations/index.html.twig', [
            'controller_name' => 'ManifestationsController',
        ]);
    }
}
