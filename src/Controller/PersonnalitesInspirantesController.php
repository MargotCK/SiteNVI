<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonnalitesInspirantesController extends AbstractController
{
    #[Route('/personnalites-inspirantes', name: 'app_personnalites_inspirantes')]
    public function index(): Response
    {
        return $this->render('personnalites_inspirantes/index.html.twig', [
            'controller_name' => 'PersonnalitesInspirantesController',
        ]);
    }
}
