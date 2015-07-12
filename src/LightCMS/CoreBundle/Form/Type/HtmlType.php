<?php

namespace LightCMS\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class HtmlType extends AbstractType
{
    public function getParent()
    {
        return 'textarea';
    }

    public function getName()
    {
        return 'html';
    }
}