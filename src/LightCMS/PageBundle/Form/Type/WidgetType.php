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
class WidgetType extends AbstractType
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

        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));

        $builder->add('position', 'hidden', array(
            'label' => false,
            'attr' => array('class' => 'widgetposition')));

        $builder->add('size', 'hidden', array(
            'required' => true
        ));

        $lcmsUrl = $this->container->get('light_cms_core.service.generate_url');
        $modalUrl = $lcmsUrl->generateUrl('node', 'widget', 'row', array('id' => $options['data']->getId()));

        $builder->add('row', 'modal_entity', array(
            'label' => 'page.form.parent.label',
            'entity_class' => 'LightCMS\PageBundle\Entity\Row',
            'entity_label' => array('position'),
            'entity_repository' => 'LightCMSPageBundle:Row',
            'modal_uri' => $modalUrl
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Widget',
            'model_class' => 'LightCMS\PageBundle\Entity\Widget',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'widget';
    }
}