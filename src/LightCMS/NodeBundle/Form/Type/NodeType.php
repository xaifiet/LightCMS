<?php

namespace LightCMS\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

/**
 * Class NodeType
 * @package LightCMS\NodeBundle\Form\Type
 */
class NodeType extends AbstractType
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
        $builder->add('name', 'text', array(
            'label' => 'node.form.name.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('urlname', 'text', array(
            'label' => 'node.form.urlname.label',
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('parent', 'entity', array(
            'label' => 'page.form.parent.label',
            'class' => 'LightCMS\NodeBundle\Entity\Node',
            'choice_label' => 'name',
            'attr' => array(
                'class' => 'form-control')
        ));

        $builder->add('published', 'choice', array(
            'label' => 'page.form.published.label',
            'attr' => array(
                'class' => 'form-control'),
            'choices' => array(
                1 => 'page.form.published.yes',
                0 => 'page.form.published.no')));

        // Adding the submit button
        $builder->add('submit', 'submit');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\NodeBundle\Entity\Node',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'node';
    }
}
