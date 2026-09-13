<?php

namespace App\Controller;

use App\Repository\CarrouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarrouselRepository $carrouselRepository): Response
    {
        $carrousels = $carrouselRepository->findBy(
            ['actif' => true],
            ['ordreCarrousel' => 'ASC']
        );

        return $this->render('home/index.html.twig', [
            'carrousels' => $carrousels,
        ]);
    }
}
