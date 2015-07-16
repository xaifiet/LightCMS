<?php

namespace LightCMS\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

class FolderType extends AbstractType
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
        $builder->add('header', 'textarea', array(
            'label' => 'page.form.header.label',
            'required' => false,
            'attr' => array(
                'class' => 'form-control summernote')));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\NodeBundle\Entity\Folder',
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
        return 'folder';
    }
}
