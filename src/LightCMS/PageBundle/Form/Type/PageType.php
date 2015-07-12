<?php

namespace LightCMS\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;


/**
 * Class PageType
 * @package LightCMS\PageBundle\Form\Type
 */
class PageType extends AbstractType
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
        $builder->add('header', 'html', array(
            'label' => 'page.form.header.label'));

        $builder->add('body', 'html', array(
            'label' => 'page.form.body.label'));

        $builder->add('footer', 'html', array(
            'label' => 'page.form.footer.label'));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\PageBundle\Entity\Page',
            'cascade_validation' => true,
            'submit_label' => 'form.submit.default',
            'cancel_label' => 'form.submit.cancel'
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'node';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'page';
    }
}
