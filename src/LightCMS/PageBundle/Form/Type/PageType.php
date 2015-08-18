<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class PageType extends AbstractType
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

        $builder->add('name', 'text', array(
            'label' => 'page.form.name.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('url', 'text', array(
            'label' => 'page.form.url.label',
            'attr' => array(
                'class' => 'form-control')));

        $lcmsUrl = $this->container->get('light_cms_core.service.generate_url');
        $modalUrl = $lcmsUrl->generateUrl('node', 'page', 'parentEntity', array('id' => $options['data']->getId()));

        $builder->add('parent', 'modal_entity', array(
            'label' => 'page.form.parent.label',
            'entity_class' => 'LightCMS\PageBundle\Entity\Node',
            'entity_label' => array('name'),
            'entity_repository' => 'LightCMSPageBundle:Node',
            'modal_uri' => $modalUrl
        ));

//        $builder->add('parent', 'entity', array(
//            'label' => 'page.form.parent.label',
//            'class' => 'LightCMS\PageBundle\Entity\Node',
//            'choice_label' => 'name',
//            'attr' => array(
//                'class' => 'form-control')
//        ));

        // Adding the submit button
        $builder->add('submit', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-success'
            )
        ));

        if (!is_null($options['data']->getPublished())) {
            $builder->add('unpublish', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-danger'
                ),
                'label' => 'Unpublish'
            ));
        }

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