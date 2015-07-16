<?php

namespace LightCMS\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

/**
 * Class SiteType
 * @package LightCMS\SiteBundle\Form\Type
 */
class SiteType extends AbstractType
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // Adding the node name
        $builder->add('title', 'text', array(
            'label' => 'site.form.name.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('host', 'text', array(
            'label' => 'site.form.host.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('layout', 'text', array(
            'label' => 'site.form.layout.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('priority', 'integer', array(
            'label' => 'site.form.priority.label',
            'attr' => array(
                'class' => 'form-control'),
            'scale' => 0
        ));

        $builder->add('rootNode', 'entity', array(
            'label' => 'page.form.type.rootNode.label',
            'class' => 'LightCMS\NodeBundle\Entity\Folder',
            'choice_label' => 'name',
        ));

        $builder->add('homeNode', 'entity', array(
            'label' => 'page.form.type.homeNode.label',
            'class' => 'LightCMS\NodeBundle\Entity\Node',
            'choice_label' => 'name',
            'attr' => array(
                'class' => 'form-control')
        ));

        // Adding the submit button
        $builder->add('submit', 'submit');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\SiteBundle\Entity\Site',
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
