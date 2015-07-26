<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

use LightCMS\PageBundle\Form\DataTransformer\RowsToScalarClassTransformer;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class VersionType extends AbstractType
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

        $builder->add($builder->create('rows', 'collection', array(
            'attr' => array('data-bind' => 'ready[sortable(.sorthandle,.rowposition,box box-primary placeholder)]'),
            'type' => 'row',
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true,
            'label' => false)));
//            ->addModelTransformer(new RowsToScalarClassTransformer($this->entityManager, $options['data'])));

        $builder->add('submit', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-success'
            )
        ));

        if ($options['data']->getPage()->getPublished() != $options['data']) {
            $builder->add('publish', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
                'label' => 'Publish'
            ));
        }

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Version',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'version';
    }
}