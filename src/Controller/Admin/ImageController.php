<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\ImageEditType;
use App\Form\ImageUploadType;
use App\Repository\ImageRepository;
use App\Service\CloudinaryUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/images')]
class ImageController extends AbstractController
{
    #[Route('/', name: 'app_admin_image_index')]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('admin/image/index.html.twig', [
            'images' => $imageRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_image_new')]
    public function new(
        Request $request,
        CloudinaryUploader $cloudinaryUploader,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ImageUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('fichier')->getData();

            $result = $cloudinaryUploader->upload(
                $uploadedFile->getPathname(),
                'sitenvi/images'
            );

            $image = new Image();
            $image->setNomFichier($uploadedFile->getClientOriginalName());
            $image->setChemin($result['url']);
            $image->setPublicId($result['publicId']);
            $image->setTexteAlternatif($form->get('texteAlternatif')->getData());
            $image->setDateUpload(new \DateTimeImmutable());

            $entityManager->persist($image);
            $entityManager->flush();

            $this->addFlash('success', 'Image envoyée avec succès.');

            return $this->redirectToRoute('app_admin_image_index');
        }

        return $this->render('admin/image/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_admin_image_edit', methods: ['GET', 'POST'])]
    public function edit(
        Image $image,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ImageEditType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Texte alternatif modifié avec succès.');

            return $this->redirectToRoute('app_admin_image_index');
        }

        return $this->render('admin/image/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: 'app_admin_image_delete', methods: ['POST'])]
    public function delete(
        Image $image,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isCsrfTokenValid('delete_image_' . $image->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }

        if (
            !$image->getOffres()->isEmpty() ||
            !$image->getContenuEditorials()->isEmpty() ||
            !$image->getCarrousels()->isEmpty()
        ) {
            $this->addFlash('danger', 'Impossible de supprimer cette image : elle est utilisée sur le site.');

            return $this->redirectToRoute('app_admin_image_index');
        }

        $this->addFlash(
            'danger',
            'La suppression est temporairement désactivée pour protéger les images utilisées sur les pages du site.'
        );

        return $this->redirectToRoute('app_admin_image_index');
    }
}
