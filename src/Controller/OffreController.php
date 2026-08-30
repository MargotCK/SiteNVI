<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OffreController extends AbstractController
{
    #[Route('/offres/{slug}', name: 'app_offre_show')]
    public function show(string $slug): Response
    {
        return $this->render('offre/show.html.twig', [
            'slug' => $slug,
        ]);
    }
}