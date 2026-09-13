<?php

namespace App\Form;

use App\Entity\CategorieOffre;
use App\Entity\Image;
use App\Entity\Offre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 6,
                ],
            ])

            ->add('horaires', TextType::class, [
                'label' => 'Horaires',
                'required' => false,
            ])

            ->add('lieu', TextType::class, [
                'label' => 'Lieu',
                'required' => false,
            ])

            ->add('niveau', ChoiceType::class, [
                'label' => 'Niveau',
                'required' => false,
                'placeholder' => 'Aucun niveau',
                'choices' => [
                    'Tous niveaux' => 'Tous niveaux',
                    'Débutant' => 'Débutant',
                    'Intermédiaire' => 'Intermédiaire',
                    'Avancé' => 'Avancé',
                ],
            ])

            ->add('publicVise', ChoiceType::class, [
                'label' => 'Public visé',
                'required' => false,
                'placeholder' => 'Choisir un public',
                'choices' => [
                    'Tout public' => 'Tout public',
                    'Enfants' => 'Enfants',
                    'Adolescents' => 'Adolescents',
                    'Adultes' => 'Adultes',
                ],

            ])

    
            ->add('categorieOffre', EntityType::class, [
                'class' => CategorieOffre::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
            ])

            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'nomFichier',
                'label' => 'Image',
                'placeholder' => 'Aucune image',
                'required' => false,
            ])

            ->add('actif', CheckboxType::class, [
                'label' => 'Publier cette offre',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}