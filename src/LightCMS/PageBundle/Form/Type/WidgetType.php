<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class WidgetType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add($builder->create('id', 'hidden'));

        $builder->add($builder->create('type', 'hidden'));

        $builder->add($builder->create('title', 'text', array(
            'required' => false
        )));

        $builder->add($builder->create('size', 'text', array(
            'required' => false
        )));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\CoreBundle\Util\ScalarUtil',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'widget';
    }
}