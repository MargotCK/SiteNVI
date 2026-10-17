<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BoutiqueController extends AbstractController
{
    #[Route('/boutique/', name: 'app_boutique')]
    public function index(ImageRepository $imageRepository): Response
    {
        $flyer = $imageRepository->findOneBy([
            'nomFichier' => 'nous-vous-iles-boutiques-en-ligne-livres-poupees-madras.png',
        ]);

        return $this->render('boutique/index.html.twig', [
            'flyer' => $flyer,
        ]);
    }
}