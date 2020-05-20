<?php

namespace AcMarche\Patrimoine\Form;

use AcMarche\Patrimoine\Entity\Patrimoine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalisationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'latitude',
                TextType::class,
                [
                    'attr' => ['placeholder' => 'latitude'],
                ]
            )
            ->add(
                'longitude',
                TextType::class,
                [
                    'attr' => ['placeholder' => 'longitude'],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => Patrimoine::class)
        );
    }
}
