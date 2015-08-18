<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ManagerRegistry;

use LightCMS\CoreBundle\Form\EventListener\ModalEntityFormSubscriber;

class ModalEntityType extends AbstractType
{

    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['modal_uri'] = $options['modal_uri'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('id', 'hidden', array(
            'mapped' => false,
            'required' => false
        ));

        $builder->add('name', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => false,
            'mapped' => false,
            'required' => false
        ));

        $builder->addEventSubscriber(new ModalEntityFormSubscriber(
            $this->registry,
            $options['entity_class'],
            $options['entity_repository'],
            $options['entity_label']
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => false,
        ));

        $resolver->setRequired(array(
            'entity_label',
            'entity_class',
            'entity_repository',
            'modal_uri'
        ));
    }

    public function getName()
    {
        return 'modal_entity';
    }
}