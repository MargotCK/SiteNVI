<?php

namespace App\Form;

use App\Entity\CategorieContenu;
use App\Entity\ContenuEditorial;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenuEditorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'Titre',
            ])
            ->add('resume', null, [
                'label' => 'Résumé',
                'required' => false,
            ])
            ->add('contenu', null, [
                'label' => 'Contenu',
            ])
            ->add('meta_description', null, [
                'label' => 'Meta description',
                'required' => false,
            ])
            ->add('categorieContenu', EntityType::class, [
                'class' => CategorieContenu::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'texteAlternatif',
                'label' => 'Image',
                'placeholder' => 'Aucune image',
                'required' => false,
            ])
            ->add('actif', null, [
                'label' => 'Actif',
                'required' => false,
            ])
        ;
    }
}
