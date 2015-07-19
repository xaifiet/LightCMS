<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Doctrine\ORM\EntityManager;

/**
 * Class PageType
 * @package LightCMS\CoreBundle\Form\Type
 */
class CollectionInheritanceType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $prototypes = array();

        if ($options['allow_add'] && $options['prototype']) {
            foreach ($options['types'] as $label => $type) {
                $prototypes[$label] = $builder->create($type, $type, array_replace(array(
                    'label' => $type . 'label__'
                ), $options['options']))->getForm();
            }
        }
        $builder->setAttribute('prototypes', $prototypes);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['allow_add']    = $options['allow_add'];
        $view->vars['allow_delete'] = $options['allow_delete'];
        if ($form->getConfig()->hasAttribute('prototypes')) {
            $view->vars['prototypes'] = array_map(function (FormInterface $prototype) use ($view) {
                return $prototype->createView($view);
            }, $form->getConfig()->getAttribute('prototypes'));
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_add'      => false,
            'allow_delete'   => false,
            'prototype'      => true,
            'prototype_name' => '__name__',
            'type_name'      => '_type',
            'options'        => array(),
        ));
        $resolver->setRequired(array(
            'types'
        ));

        $resolver->setAllowedTypes('types', 'array');
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'collectioninheritance';
    }
}