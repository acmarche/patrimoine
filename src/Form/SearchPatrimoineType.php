<?php

namespace AcMarche\Patrimoine\Form;

use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Entity\Statut;
use AcMarche\Patrimoine\Entity\TypePatrimoine;
use AcMarche\Patrimoine\Repository\LocaliteRepository;
use AcMarche\Patrimoine\Repository\TypePatrimoineRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPatrimoineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nom',
                SearchType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'localite',
                ChoiceType::class,
                [
                    'choices' => array_combine(LocaliteRepository::getList(), LocaliteRepository::getList()),
                    'required' => false,
                ]
            )
            ->add(
                'typePatrimoine',
                EntityType::class,
                [
                    'class' => TypePatrimoine::class,
                    'query_builder' => function (TypePatrimoineRepository $typePatrimoineRepository) {
                        return $typePatrimoineRepository->getForList();
                    },
                    'required' => false,
                ]
            )
            ->add(
                'statut',
                EntityType::class,
                [
                    'class' => Statut::class,
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [

            ]
        );
    }
}
