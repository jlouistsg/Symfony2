<?php

namespace Esgi\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProposePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add(
            'title',
            'text',
            array(
                'attr' => array(
                    'label' => 'Titre',
                    'placeholder' => 'Titre de l\'article',
                ),
            )
        )
        ->add(
            'body',
            'textarea',
            array(
                'attr' => array(
                    'class' => 'tinymce',
                    'label' => 'Contenu',
                    'placeholder' => 'Contenu de l\'article',
                ),
            )
        )
        ->add(
            'category',
            null,
            array(
                'attr' => array(
                    'label' => 'Catégorie',
                    'placeholder' => 'Choisissez une catégorie',
                ),
            )
        )
        ->add(
            'save',
            'submit',
            array(
                'attr' => array(
                    'label' => 'Proposer',
                ),
            )
        );
    }

    public function getName()
    {
        return 'proposeposttype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Esgi\BlogBundle\Entity\Post', )
            );
    }
}
