<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

use LightCMS\PageBundle\Form\DataTransformer\WidgetsToScalarClassTransformer;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class RowType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('id', 'hidden');

        $builder->add($builder->create('widgets', 'collectioninheritance', array(
            'type' => 'widget',
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'label' => 'widgets',
            'prototype' => true,
            'types' => array(
                'widget.form.type.content.label' => 'widgetcontent',
                'widget.form.type.image.label' => 'widgetimage'
                )))
            ->addModelTransformer(new WidgetsToScalarClassTransformer($this->entityManager, null)));

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
        return 'row';
    }
}