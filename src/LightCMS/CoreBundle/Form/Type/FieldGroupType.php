<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;


/**
 * Class PageType
 * @package LightCMS\CoreBundle\Form\Type
 */
class FieldGroupType extends AbstractType
{

    /**
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fieldgroup';
    }
}
