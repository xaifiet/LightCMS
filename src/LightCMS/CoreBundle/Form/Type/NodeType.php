<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * Class NodeType
 * @package LightCMS\NodeBundle\Form\Type
 */
class NodeType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('parent', 'entity', array(
            'label' => 'page.form.parent.label',
            'class' => 'LightCMS\CoreBundle\Entity\Node',
            'choice_label' => 'name',
            'attr' => array(
                'class' => 'form-control')
        ));

        // Adding the submit button
        $builder->add('submit', 'submit');
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        /** @var FormView[] $fields */
        if ($view->offsetExists('submit_group')) {

            $fields = array($view->offsetGet('submit_group'));
            $view->offsetUnset('submit_group');

            $view->children = $view->children + $fields;
        }

        parent::finishView($view, $form, $options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LightCMS\CoreBundle\Entity\Node',
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