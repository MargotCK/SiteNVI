<?php

namespace App\Form;

use App\Entity\Carrousel;
use App\Entity\ContenuEditorial;
use App\Entity\Image;
use App\Entity\Offre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarrouselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ordreCarrousel', IntegerType::class, [
                'label' => 'Ordre d’affichage',
            ])

            ->add('actif', CheckboxType::class, [
                'label' => 'Afficher dans le carrousel',
                'required' => false,
            ])

            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'nomFichier',
                'label' => 'Image',
                'placeholder' => 'Choisir une image',
            ])

            ->add('offre', EntityType::class, [
                'class' => Offre::class,
                'choice_label' => 'titre',
                'label' => 'Offre associée',
                'placeholder' => 'Aucune offre',
                'required' => false,
            ])

            ->add('contenuEditorial', EntityType::class, [
                'class' => ContenuEditorial::class,
                'choice_label' => 'titre',
                'label' => 'Contenu éditorial associé',
                'placeholder' => 'Aucun contenu éditorial',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carrousel::class,
        ]);
    }
}