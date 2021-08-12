<?php

namespace AcMarche\Patrimoine\Form;

use AcMarche\Patrimoine\Entity\Localite;
use AcMarche\Patrimoine\Entity\Statut;
use AcMarche\Patrimoine\Entity\TypePatrimoine;
use AcMarche\Patrimoine\Repository\LocaliteRepository;
use AcMarche\Patrimoine\Repository\TypePatrimoineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPatrimoineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                SearchType::class,
                [
                    'required' => false,
                    'attr' => ['placeholder' => 'Nom'],
                ]
            )
            ->add(
                'localite',
                EntityType::class,
                [
                    'class' => Localite::class,
                    'query_builder' => fn(LocaliteRepository $localiteRepository
                    ) => $localiteRepository->getList(),
                    'required' => false,
                    'placeholder' => 'Localité',
                ]
            )
            ->add(
                'typePatrimoine',
                EntityType::class,
                [
                    'class' => TypePatrimoine::class,
                    'query_builder' => fn(TypePatrimoineRepository $typePatrimoineRepository
                    ) => $typePatrimoineRepository->getForList(),
                    'required' => false,
                    'placeholder' => 'Type',
                ]
            )
            ->add(
                'statut',
                EntityType::class,
                [
                    'class' => Statut::class,
                    'required' => false,
                    'placeholder' => 'Statut',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [

            ]
        );
    }
}
