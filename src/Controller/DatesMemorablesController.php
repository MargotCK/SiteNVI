<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DatesMemorablesController extends AbstractController
{
    #[Route('/dates-memorables', name: 'app_dates_memorables')]
    public function index(): Response
    {
        return $this->render('dates_memorables/index.html.twig', [
            'controller_name' => 'DatesMemorablesController',
        ]);
    }
}
