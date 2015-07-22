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
class PageType extends AbstractType
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

        $groupPage = $builder->add('page_group', 'fieldgroup', array(
            'mapped' => false,
            'label' => 'Site Informations',
            'inherit_data' => true
        ))->get('page_group');

        $groupPage->add('name', 'text', array(
            'label' => 'page.form.name.label',
            'attr' => array(
                'class' => 'form-control')));

        $groupPage->add('url', 'text', array(
            'label' => 'page.form.url.label',
            'attr' => array(
                'class' => 'form-control')));

        $groupPage->add('published', 'choice', array(
            'label' => 'page.form.published.label',
            'attr' => array(
                'class' => 'form-control'),
            'choices' => array(
                1 => 'page.form.published.yes',
                0 => 'page.form.published.no')));

        $groupPage->add('parent', 'entity', array(
            'label' => 'page.form.parent.label',
            'class' => 'LightCMS\PageBundle\Entity\Node',
            'choice_label' => 'name',
            'attr' => array(
                'class' => 'form-control')
        ));

        $builder->add($builder->create('rows', 'collection', array(
            'attr' => array('data-bind' => 'ready[sortable(.sorthandle)]'),
            'type' => 'row',
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true,
            'label' => false)));
//            ->addModelTransformer(new RowsToScalarClassTransformer($this->entityManager, $options['data'])));

        // Adding the submit button
        $builder->add('submit', 'submit', array(
            'attr' => array(
                'style' => 'display:none'
            )
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Page',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'page';
    }
}