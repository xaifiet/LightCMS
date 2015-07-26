<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

use LightCMS\PageBundle\Form\DataTransformer\RowsToScalarClassTransformer;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class NodeEntityType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        var_dump($options['id_reader']);
        $builder->add('parent', 'hidden', array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control')));

        $builder->add('name', 'text', array(
            'mapped' => false,
            'data' => 'pourt',
            'label' => false,
            'attr' => array(
                'class' => 'form-control')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Node',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nodeentity';
    }
}