<?php

namespace App\Controller;

use App\Repository\ContenuEditorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContenuEditorialController extends AbstractController
{
    #[Route('/contenus/{slug}', name: 'app_contenu_editorial_show')]
    public function show(
        string $slug,
        ContenuEditorialRepository $contenuEditorialRepository
    ): Response {
        $contenuEditorial = $contenuEditorialRepository->findOneBy([
            'slug' => $slug,
            'actif' => true,
        ]);

        if (!$contenuEditorial) {
            throw $this->createNotFoundException('Ce contenu éditorial n’existe pas ou n’est pas publié.');
        }

        return $this->render('contenu_editorial/show.html.twig', [
            'contenuEditorial' => $contenuEditorial,
        ]);
    }
}