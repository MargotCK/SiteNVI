<?php

namespace App\Controller;

use App\Repository\ContenuEditorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RessourcesEducativesController extends AbstractController
{
    #[Route('/ressources-educatives', name: 'app_ressources_educatives')]
    public function index(
        ContenuEditorialRepository $contenuEditorialRepository
    ): Response {
        $contenuEditorial = $contenuEditorialRepository
            ->createQueryBuilder('contenu')
            ->join('contenu.categorieContenu', 'categorie')
            ->andWhere('categorie.slug = :slug')
            ->andWhere('contenu.actif = :actif')
            ->setParameter('slug', 'ressources-educatives')
            ->setParameter('actif', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->render('ressources_educatives/index.html.twig', [
            'contenuEditorial' => $contenuEditorial,
        ]);
    }
}