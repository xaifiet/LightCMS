<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

/**
 * Class NodeType
 * @package LightCMS\CoreBundle\Form\Type
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
            'label' => 'node.form.name.label'));

        $builder->add('urlname', 'text', array(
            'label' => 'node.form.urlname.label'));

        $builder->add('parent', 'entity', array(
            'label' => 'page.form.type.parent.label',
            'class' => 'LightCMS\CoreBundle\Entity\Node',
            'choice_label' => 'name',
        ));

        $builder->add('published', 'choice', array(
            'label' => 'page.form.content.label',
            'choices' => array(
                1 => 'page.form.published.yes',
                0 => 'page.form.published.no')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\CoreBundle\Entity\Node',
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
        return 'node';
    }
}
