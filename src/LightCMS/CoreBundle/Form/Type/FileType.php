<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ManagerRegistry;

class FileType extends AbstractType
{

    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('directory', 'hidden', array(
            'mapped' => false,
            'required' => false
        ));

        $builder->add('file', 'file', array(
            'required' => false
        ));

        $builder->add('filename', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => false,
            'mapped' => false,
            'required' => false
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\CoreBundle\Entity\File',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'file_upload';
    }
}