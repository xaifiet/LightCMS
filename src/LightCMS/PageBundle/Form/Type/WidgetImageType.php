<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class WidgetImageType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('file', 'file', array(
            'mapped' => false,
            'label' => 'image.form.file.label',
            'required' => false));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\WidgetImage',
            'model_class' => 'LightCMS\PageBundle\Entity\WidgetImage',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'widget';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'widgetimage';
    }
}