<?php

namespace LightCMS\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FolderType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $groupHeader = $builder->add('header_group', 'fieldgroup', array(
            'mapped' => false,
            'label' => 'Page Header',
            'inherit_data' => true
        ))->get('header_group');

        // Adding the node name
        $groupHeader->add('header', 'textarea', array(
            'label' => 'folder.form.header.label',
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
            'cascade_validation' => true
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
