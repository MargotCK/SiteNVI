<?php

namespace App\Controller;

use App\Repository\ContenuEditorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonnalitesInspirantesController extends AbstractController
{
    #[Route('/personnalites-inspirantes', name: 'app_personnalites_inspirantes')]
    public function index(
        ContenuEditorialRepository $contenuEditorialRepository
    ): Response {
        $contenuEditorial = $contenuEditorialRepository
            ->createQueryBuilder('contenu')
            ->join('contenu.categorieContenu', 'categorie')
            ->andWhere('categorie.slug = :slug')
            ->andWhere('contenu.actif = :actif')
            ->setParameter('slug', 'personnalites-inspirantes')
            ->setParameter('actif', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->render('personnalites_inspirantes/index.html.twig', [
            'contenuEditorial' => $contenuEditorial,
        ]);
    }
}
