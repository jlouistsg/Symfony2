<?php

namespace Esgi\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProposeCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name')
        ->add('content','textarea', array(
                'attr' => array(
                    'class' => 'tinymce'
                )
            )
        )
        ->add('save', 'submit');
    }

    public function getName()
    {
        return 'proposeposttype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Esgi\BlogBundle\Entity\Comment', )
            );
    }
}
