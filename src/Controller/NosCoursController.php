<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NosCoursController extends AbstractController
{
    #[Route('/nos-cours', name: 'app_nos_cours')]
    public function index(): Response
    {
        return $this->render('nos_cours/index.html.twig', [
            'controller_name' => 'NosCoursController',
        ]);
    }
}
