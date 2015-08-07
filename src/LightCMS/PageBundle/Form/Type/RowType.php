<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Doctrine\ORM\EntityManager;

use LightCMS\PageBundle\Form\DataTransformer\WidgetsToScalarClassTransformer;

/**
 * Class PageType
 * @package LightCMS\NodeBundle\Form\Type
 */
class RowType extends AbstractType
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

        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));

        $builder->add('position', 'hidden', array(
            'label' => false,
            'attr' => array('class' => 'rowposition')));

        $builder->add('widgets', 'infinite_form_polycollection', array(
            'attr' => array(
                'data-bind' => 'ready[sortable(.sorthandle)]',
                'data-positions' => '.widgetposition'
            ),
            'types' => array(
                'widgetcontent',
            ),
            'allow_add' => true,
            'allow_delete' => true
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Row',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'row';
    }
}