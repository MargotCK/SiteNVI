<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Form\ImageUploadType;
use App\Service\CloudinaryUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/images')]
class ImageController extends AbstractController
{
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

            return $this->redirectToRoute('app_admin_image_new');
        }

        return $this->render('admin/image/new.html.twig', [
            'form' => $form,
        ]);
    }
}