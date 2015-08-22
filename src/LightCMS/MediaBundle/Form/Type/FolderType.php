<?php

namespace LightCMS\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class FolderType extends AbstractType
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

        $lcmsUrl = $this->container->get('light_cms_core.service.generate_url');
        $modalUrl = $lcmsUrl->generateUrl('media', 'media', 'parent', array('id' => $options['data']->getId()));

        $builder->add('parent', 'modal_entity', array(
            'label' => 'folder.form.parent.label',
            'entity_class' => 'LightCMS\MediaBundle\Entity\Folder',
            'entity_label' => array('name'),
            'entity_repository' => 'LightCMSMediaBundle:Folder',
            'modal_uri' => $modalUrl
        ));

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
            'data_class' => 'LightCMS\MediaBundle\Entity\Folder',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'folder';
    }
}