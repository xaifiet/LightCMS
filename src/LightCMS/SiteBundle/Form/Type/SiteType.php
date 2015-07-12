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
            'label' => 'site.form.name.label'));

        $builder->add('host', 'text', array(
            'label' => 'site.form.host.label'));

        $builder->add('layout', 'text', array(
            'label' => 'site.form.layout.label'));

        $builder->add('priority', 'integer', array(
            'label' => 'site.form.priority.label',
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
        ));

        // Adding the submit button
        $builder->add('submit', 'submit', array(
            'label' => 'Save'));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\SiteBundle\Entity\Site',
            'cascade_validation' => true,
            'submit_label' => 'form.submit.default',
            'cancel_label' => 'form.submit.cancel'
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
