<?php

namespace LightCMS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class UserType
 * @package LightCMS\SiteBundle\Form\Type
 */
class UserType extends AbstractType
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

        $builder->add('email', 'email', array(
            'label' => 'user.form.email.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('firstname', 'text', array(
            'label' => 'user.form.firstname.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('lastname', 'text', array(
            'label' => 'user.form.lastname.label',
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
            'data_class' => 'LightCMS\UserBundle\Entity\User',
            'cascade_validation' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
