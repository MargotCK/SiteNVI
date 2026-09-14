<?php

namespace App\Controller\Admin;

use App\Entity\Carrousel;
use App\Form\CarrouselType;
use App\Repository\CarrouselRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/carrousel')]
class CarrouselController extends AbstractController
{
    #[Route('/', name: 'app_admin_carrousel_index')]
    public function index(CarrouselRepository $carrouselRepository): Response
    {
        $carrousels = $carrouselRepository->findBy(
            [],
            ['ordreCarrousel' => 'ASC']
        );

        return $this->render('admin/carrousel/index.html.twig', [
            'carrousels' => $carrousels,
        ]);
    }

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

    #[Route('/{id}/edit', name: 'app_admin_carrousel_edit')]
    public function edit(
        Carrousel $carrousel,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CarrouselType::class, $carrousel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Élément du carrousel modifié avec succès.'
            );

            return $this->redirectToRoute('app_admin_carrousel_index');
        }

        return $this->render('admin/carrousel/edit.html.twig', [
            'form' => $form,
            'carrousel' => $carrousel,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_carrousel_delete', methods: ['POST'])]
    public function delete(
        Carrousel $carrousel,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid(
            'delete'. $carrousel->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($carrousel);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Élément du carrousel supprimé avec succès.'
            );
        }

        return $this->redirectToRoute('app_admin_carrousel_index');
    }
}