<?php

namespace App\Controller\Admin;

use App\Entity\LienExterne;
use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\CategorieLienRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/offres')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_admin_offre_index')]
    public function index(OffreRepository $offreRepository): Response
    {
        return $this->render('admin/offre/index.html.twig', [
            'offres' => $offreRepository->findBy([], [
                'dateCreation' => 'DESC',
            ]),
        ]);
    }

    #[Route('/new', name: 'app_admin_offre_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        CategorieLienRepository $categorieLienRepository
    ): Response {
        $offre = new Offre();

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($offre->getTitre())->lower();

            $offre->setSlug($slug->toString());
            $offre->setDateCreation(new \DateTimeImmutable());

            $helloassoUrl = $form->get('helloassoUrl')->getData();
            $helloassoLibelle = $form->get('helloassoLibelle')->getData();
            $helloassoActif = $form->get('helloassoActif')->getData();

            if ($helloassoUrl) {
                $categorieHelloAsso = $categorieLienRepository->findOneBy([
                    'slug' => 'helloasso',
                ]);

                if ($categorieHelloAsso) {
                    $lienExterne = new LienExterne();
                    $lienExterne->setUrlHelloasso($helloassoUrl);
                    $lienExterne->setLibelle($helloassoLibelle ?: 'Je découvre les offres sur HelloAsso');
                    $lienExterne->setActif((bool) $helloassoActif);
                    $lienExterne->setCategorieLien($categorieHelloAsso);
                    $lienExterne->setOffre($offre);

                    $offre->setLienExterne($lienExterne);

                    $entityManager->persist($lienExterne);
                }
            }

            $entityManager->persist($offre);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L’offre a été créée avec succès.'
            );

            return $this->redirectToRoute('app_admin_offre_index');
        }

        return $this->render('admin/offre/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_offre_edit', requirements: ['id' => '\d+'])]
    public function edit(
        Offre $offre,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        CategorieLienRepository $categorieLienRepository
    ): Response {
        $form = $this->createForm(OffreType::class, $offre, [
            'helloasso_libelle' => $offre->getLienExterne()?->getLibelle(),
            'helloasso_url' => $offre->getLienExterne()?->getUrlHelloasso(),
            'helloasso_actif' => $offre->getLienExterne()?->isActif() ?? false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($offre->getTitre())->lower();

            $offre->setSlug($slug->toString());
            $offre->setDateModification(new \DateTime());

            $helloassoUrl = $form->get('helloassoUrl')->getData();
            $helloassoLibelle = $form->get('helloassoLibelle')->getData();
            $helloassoActif = $form->get('helloassoActif')->getData();

            $lienExterne = $offre->getLienExterne();

            if ($helloassoUrl) {
                if (!$lienExterne) {
                    $categorieHelloAsso = $categorieLienRepository->findOneBy([
                        'slug' => 'helloasso',
                    ]);

                    if ($categorieHelloAsso) {
                        $lienExterne = new LienExterne();
                        $lienExterne->setCategorieLien($categorieHelloAsso);
                        $lienExterne->setOffre($offre);

                        $offre->setLienExterne($lienExterne);

                        $entityManager->persist($lienExterne);
                    }
                }

                if ($lienExterne) {
                    $lienExterne->setUrlHelloasso($helloassoUrl);
                    $lienExterne->setLibelle($helloassoLibelle ?: 'Je découvre les offres sur HelloAsso');
                    $lienExterne->setActif((bool) $helloassoActif);
                }
            } elseif ($lienExterne) {
                $entityManager->remove($lienExterne);
            }

            $entityManager->flush();

            $this->addFlash(
                'success',
                'L’offre a été modifiée avec succès.'
            );

            return $this->redirectToRoute('app_admin_offre_index');
        }

        return $this->render('admin/offre/edit.html.twig', [
            'form' => $form,
            'offre' => $offre,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_offre_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        Offre $offre,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete_offre_' . $offre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L’offre a été supprimée avec succès.'
            );
        }

        return $this->redirectToRoute('app_admin_offre_index');
    }
}