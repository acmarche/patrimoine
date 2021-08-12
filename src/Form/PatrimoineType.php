<?php

namespace AcMarche\Patrimoine\Form;

use AcMarche\Patrimoine\Entity\Localite;
use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Entity\Statut;
use AcMarche\Patrimoine\Entity\TypePatrimoine;
use AcMarche\Patrimoine\Repository\LocaliteRepository;
use AcMarche\Patrimoine\Repository\TypePatrimoineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatrimoineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('rue', TextType::class, [
                'required' => false,
            ])
            ->add('numero', TextType::class, [
                'required' => false,
            ])
            ->add('codePostal', TextType::class, [
                'required' => false,
            ])
            ->add(
                'localite',
                EntityType::class,
                [
                    'class' => Localite::class,
                    'query_builder' => fn(LocaliteRepository $localiteRepository) => $localiteRepository->getList(),
                    'required' => true,
                    'placeholder' => 'Sélectionnez',
                ]
            )
            ->add(
                'descriptif',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'commentaire',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'typePatrimoine',
                EntityType::class,
                [
                    'class' => TypePatrimoine::class,
                    'query_builder' => fn(TypePatrimoineRepository $typePatrimoineRepository
                    ) => $typePatrimoineRepository->getForList(),
                    'placeholder' => 'Sélectionnez',
                ]
            )->add(
                'statut',
                EntityType::class,
                [
                    'class' => Statut::class,
                    'placeholder' => 'Sélectionnez',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Patrimoine::class,
            ]
        );
    }
}
