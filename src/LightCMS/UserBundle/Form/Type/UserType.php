<?php

namespace LightCMS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class UserType
 * @package LightCMS\UserBundle\Form\Type
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

        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'required' => false,
            'options' => array('required' => false),
            'first_options' => array(
                'label' => 'user.form.password_first.label',
                'required' => false,
                'attr' => array('class' => 'form-control')
            ),
            'second_options' => array(
                'label' => 'user.form.password_second.label',
                'required' => false,
                'attr' => array('class' => 'form-control')
            )));

        $builder->add('isPasswordExpired', 'choice', array(
            'label' => 'user.form.expired_password.label',
            'choices' => array(
                0 => 'NO',
                1 => 'YES'
            ),
            'attr' => array(
        'class' => 'form-control')));

        $builder->add('role', 'choice', array(
            'label' => 'user.form.role.label',
            'choices' => array(
                'ROLE_USER' => 'User',
                'ROLE_ADMIN' => 'Administrator'
            ),
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('isActive', 'choice', array(
            'label' => 'user.form.active.label',
            'choices' => array(
                0 => 'NO',
                1 => 'YES'
            ),
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
