<?php

namespace App\Controller;

use App\Repository\ContenuEditorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ManifestationsController extends AbstractController
{
    #[Route('/manifestations', name: 'app_manifestations')]
    public function index(
        ContenuEditorialRepository $contenuEditorialRepository
    ): Response {
        $contenuEditorial = $contenuEditorialRepository
            ->createQueryBuilder('contenu')
            ->join('contenu.categorieContenu', 'categorie')
            ->andWhere('categorie.slug = :slug')
            ->andWhere('contenu.actif = :actif')
            ->setParameter('slug', 'manifestations')
            ->setParameter('actif', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->render('manifestations/index.html.twig', [
            'contenuEditorial' => $contenuEditorial,
        ]);
    }
}