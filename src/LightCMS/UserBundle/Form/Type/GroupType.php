<?php

namespace LightCMS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class groupType
 * @package LightCMS\USerBundle\Form\Type
 */
class GroupType extends AbstractType
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
            'label' => 'group.form.name.label',
            'attr' => array(
                'class' => 'form-control'
            )
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
            'data_class' => 'LightCMS\UserBundle\Entity\Group',
            'cascade_validation' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'group';
    }
}
