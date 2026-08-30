<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RessourcesEducativesController extends AbstractController
{
    #[Route('/ressources-educatives', name: 'app_ressources_educatives')]
    public function index(): Response
    {
        return $this->render('ressources_educatives/index.html.twig', [
            'controller_name' => 'RessourcesEducativesController',
        ]);
    }
}
