<?php

namespace AcMarche\Patrimoine\Form;

use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Entity\Statut;
use AcMarche\Patrimoine\Entity\TypePatrimoine;
use AcMarche\Patrimoine\Repository\LocaliteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatrimoineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
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
                'localite',
                ChoiceType::class,
                [
                    'choices' => array_combine(LocaliteRepository::getList(),LocaliteRepository::getList()),
                    'required' => false,
                ]
            )
            ->add(
                'typePatrimoine',
                EntityType::class,
                [
                    'class' => TypePatrimoine::class,
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Patrimoine::class,
            ]
        );
    }
}
