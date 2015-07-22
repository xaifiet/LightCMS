<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class WidgetContentType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));

        $builder->add('content', 'textarea', array(
            'label' => 'page.form.header.label',
            'required' => false,
            'data' => 'plopiac',
            'attr' => array(
                'data-bind' => 'ready[summernoteInit()]')));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\WidgetContent',
            'model_class' => 'LightCMS\PageBundle\Entity\WidgetContent',
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
        return 'widgetcontent';
    }
}