<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NodeType
 * @package LightCMS\CoreBundle\Form\Type
 */
class ActionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Adding the submit button
        $builder->add('submit', 'submit', array(
            'label' => 'form.submit.save'));

        // Adding the submit button
        $builder->add('delete', 'submit', array(
            'label' => 'form.submit.delete'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'action';
    }
}

?>