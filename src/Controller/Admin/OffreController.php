<?php

namespace App\Controller\Admin;

use App\Entity\Offre;
use App\Form\OffreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/offres')]
class OffreController extends AbstractController
{
    #[Route('/new', name: 'app_admin_offre_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $offre = new Offre();

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($offre->getTitre())->lower();

            $offre->setSlug($slug->toString());
            $offre->setDateCreation(new \DateTimeImmutable());

            $entityManager->persist($offre);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L’offre a été créée avec succès.'
            );

            return $this->redirectToRoute('app_admin_offre_new');
        }

        return $this->render('admin/offre/new.html.twig', [
            'form' => $form,
        ]);
    }
}