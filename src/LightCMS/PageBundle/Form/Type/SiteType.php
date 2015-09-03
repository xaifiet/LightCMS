<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class SiteType
 * @package LightCMS\SiteBundle\Form\Type
 */
class SiteType extends AbstractType
{

    protected $container;

    protected $router;

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

        $this->router = $container->get('router');
    }

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

        if (isset($options['data']) and !is_null($options['data']->getId())) {

            $lcmsUrl = $this->container->get('light_cms_core.service.generate_url');
            $modalUrl = $lcmsUrl->generateUrl('node', 'site', 'homeEntity', array('id' => $options['data']->getId()));

            $builder->add('home', 'modal_entity', array(
                'label' => 'page.form.type.homeNode.label',
                'entity_class' => 'LightCMS\PageBundle\Entity\Page',
                'entity_label' => array('name'),
                'entity_repository' => 'LightCMSPageBundle:Page',
                'modal_uri' => $modalUrl
            ));
        }

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
            'cascade_validation' => false,
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
