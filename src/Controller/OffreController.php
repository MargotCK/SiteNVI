<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OffreController extends AbstractController
{
    #[Route('/offres/{slug}', name: 'app_offre_show')]
    public function show(
        string $slug,
        OffreRepository $offreRepository
    ): Response {
        $offre = $offreRepository->findOneBy([
            'slug' => $slug,
            'actif' => true,
        ]);

        if (!$offre) {
            throw $this->createNotFoundException(
                'Cette offre n’existe pas ou n’est pas disponible.'
            );
        }

        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }
}