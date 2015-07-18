<?php

namespace LightCMS\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class PageType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $groupHeader = $builder->add('header_group', 'fieldgroup', array(
            'mapped' => false,
            'label' => 'Page Header',
            'inherit_data' => true
        ))->get('header_group');

        // Adding the node name
        $groupHeader->add('header', 'textarea', array(
            'label' => 'page.form.header.label',
            'required' => false,
            'attr' => array(
                'class' => 'form-control summernote')));


        $groupBody = $builder->add('body_group', 'fieldgroup', array(
            'mapped' => false,
            'label' => 'Page Body',
            'inherit_data' => true
        ))->get('body_group');

        $groupBody->add('body', 'textarea', array(
            'label' => 'page.form.body.label',
            'required' => false,
            'attr' => array(
                'class' => 'form-control summernote')));


        $groupFooter = $builder->add('footer_group', 'fieldgroup', array(
            'mapped' => false,
            'label' => 'Page Footer',
            'inherit_data' => true
        ))->get('footer_group');

        $groupFooter->add('footer', 'textarea', array(
            'label' => 'page.form.footer.label',
            'required' => false,
            'attr' => array(
                'class' => 'form-control summernote')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\NodeBundle\Entity\Page',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'node';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'page';
    }
}
