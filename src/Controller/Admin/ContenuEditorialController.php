<?php

namespace App\Controller\Admin;

use App\Entity\ContenuEditorial;
use App\Form\ContenuEditorialType;
use App\Repository\CategorieContenuRepository;
use App\Repository\ContenuEditorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/contenus')]
final class ContenuEditorialController extends AbstractController
{
    #[Route('/', name: 'app_admin_contenu_editorial_index')]
    public function index(
        ContenuEditorialRepository $contenuEditorialRepository
    ): Response {
        $contenus = $contenuEditorialRepository->findBy(
            [],
            ['date_creation' => 'DESC']
        );

        return $this->render('admin/contenu_editorial/index.html.twig', [
            'contenus' => $contenus,
        ]);
    }

    #[Route('/new', name: 'app_admin_contenu_editorial_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        CategorieContenuRepository $categorieContenuRepository
    ): Response {
        $contenu = new ContenuEditorial();

        $categorie = $categorieContenuRepository->findOneBy([
            'slug' => 'actualite',
        ]);

        if (!$categorie) {
            throw $this->createNotFoundException(
                'La catégorie Actualité est introuvable.'
            );
        }

        $contenu->setCategorieContenu($categorie);

        $form = $this->createForm(
            ContenuEditorialType::class,
            $contenu
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contenu->setSlug(
                $slugger
                    ->slug($contenu->getTitre())
                    ->lower()
                    ->toString()
            );

            if (!$contenu->getMetaDescription()) {
                $texte = strip_tags($contenu->getContenu());
                $texte = preg_replace('/\s+/', ' ', $texte);
                $texte = trim($texte);

                if (mb_strlen($texte) > 155) {
                    $texte = mb_substr($texte, 0, 155);
                    $dernierEspace = mb_strrpos($texte, ' ');

                    if ($dernierEspace !== false) {
                        $texte = mb_substr(
                            $texte,
                            0,
                            $dernierEspace
                        );
                    }
                }

                $contenu->setMetaDescription($texte);
            }

            $contenu->setDateCreation(
                new \DateTimeImmutable()
            );

            $entityManager->persist($contenu);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Contenu éditorial ajouté avec succès.'
            );

            return $this->redirectToRoute(
                'app_admin_contenu_editorial_index'
            );
        }

        return $this->render(
            'admin/contenu_editorial/new.html.twig',
            [
                'form' => $form,
            ]
        );
    }
    
    #[Route('/{id}/edit', name: 'app_admin_contenu_editorial_edit')]
    public function edit(
        ContenuEditorial $contenu,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(
            ContenuEditorialType::class,
            $contenu
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contenu->setSlug(
                $slugger
                    ->slug($contenu->getTitre())
                    ->lower()
                    ->toString()
            );

            $contenu->setDateModification(
                new \DateTime()
            );

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Contenu éditorial modifié avec succès.'
            );

            return $this->redirectToRoute(
                'app_admin_contenu_editorial_index'
            );
        }

        return $this->render(
            'admin/contenu_editorial/edit.html.twig',
            [
                'form' => $form,
                'contenu' => $contenu,
            ]
        );
    }

    #[Route(
        '/{id}/delete',
        name: 'app_admin_contenu_editorial_delete',
        methods: ['POST']
    )]
    public function delete(
        ContenuEditorial $contenu,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid(
            'delete'.$contenu->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($contenu);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Contenu éditorial supprimé avec succès.'
            );
        }

        return $this->redirectToRoute(
            'app_admin_contenu_editorial_index'
        );
    }
}