<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SiteType
 * @package LightCMS\SiteBundle\Form\Type
 */
class SiteType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', 'text', array(
            'label' => 'site.form.name.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('host', 'text', array(
            'label' => 'site.form.host.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('priority', 'integer', array(
            'label' => 'site.form.priority.label',
            'attr' => array(
                'class' => 'form-control'),
            'scale' => 0));

        $builder->add('home', 'entity', array(
            'label' => 'page.form.type.homeNode.label',
            'class' => 'LightCMS\PageBundle\Entity\Page',
            'choice_label' => 'name',
            'attr' => array(
                'class' => 'form-control')));

        // Adding the submit button
        $builder->add('submit', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-success'
            )
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Site',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site';
    }
}
