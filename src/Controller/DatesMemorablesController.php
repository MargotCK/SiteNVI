<?php

namespace App\Controller;

use App\Repository\ContenuEditorialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DatesMemorablesController extends AbstractController
{
    #[Route('/dates-memorables', name: 'app_dates_memorables')]
    public function index(
        ContenuEditorialRepository $contenuEditorialRepository
    ): Response {
        $contenuEditorial = $contenuEditorialRepository
            ->createQueryBuilder('contenu')
            ->join('contenu.categorieContenu', 'categorie')
            ->andWhere('categorie.slug = :slug')
            ->andWhere('contenu.actif = :actif')
            ->setParameter('slug', 'dates-memorables')
            ->setParameter('actif', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->render('dates_memorables/index.html.twig', [
            'contenuEditorial' => $contenuEditorial,
        ]);
    }
}