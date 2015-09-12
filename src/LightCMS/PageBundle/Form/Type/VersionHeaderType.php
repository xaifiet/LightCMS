<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

class VersionHeaderType extends AbstractType
{

    protected $container;


    /**
     * __construct function.
     *
     * @access public
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title', 'text', array(
            'label' => 'versionheader.form.title.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('content', 'textarea', array(
            'label' => 'page.form.header.label',
            'required' => false,
            'attr' => array(
                'data-bind' => 'ready[summernoteInit()]')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\VersionHeader',
            'cascade_validation' => true
        ));
    }

    public function getParent()
    {
        return 'version';
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'versionheader';
    }
}