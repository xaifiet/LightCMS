<?php

namespace LightCMS\CoreBundle\Service;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;

class DiscriminatorService
{

    private $discriminatorMap;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $container
     * @return void
     */
    public function __construct($container)
    {
        return;
    }

}

?>