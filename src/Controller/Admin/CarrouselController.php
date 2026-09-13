<?php

namespace App\Controller\Admin;

use App\Entity\Carrousel;
use App\Form\CarrouselType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/carrousel')]
class CarrouselController extends AbstractController
{
    #[Route('/new', name: 'app_admin_carrousel_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $carrousel = new Carrousel();

        $form = $this->createForm(CarrouselType::class, $carrousel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carrousel);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Élément ajouté au carrousel avec succès.'
            );

            return $this->redirectToRoute('app_admin_carrousel_new');
        }

        return $this->render('admin/carrousel/new.html.twig', [
            'form' => $form,
        ]);
    }
}