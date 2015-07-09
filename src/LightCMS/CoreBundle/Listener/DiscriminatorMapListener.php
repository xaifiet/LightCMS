<?php

namespace LightCMS\CoreBundle\Listener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;

class DiscriminatorMapListener
{
    /**
     * @var array
     */
    protected $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = array_shift($mapping);
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        $metadata = $event->getClassMetadata();
        $class = $metadata->getReflectionClass();

        if ($class === null) {
            $class = new \ReflectionClass($metadata->getName());
        }

        var_dump($class->getName());
        foreach ($this->mapping as $entityName => $map) {
            var_dump($map);
            if ($class->getName() == $map['entity']) {
                $reader = new AnnotationReader;
                $discriminatorMap = array();

                if (null !== $discriminatorMapAnnotation = $reader->getClassAnnotation($class, 'Doctrine\ORM\Mapping\DiscriminatorMap')) {
                    $discriminatorMap = $discriminatorMapAnnotation->value;
                }

                $discriminatorMap = array_merge($discriminatorMap, $map['map']);
                $discriminatorMap = array_merge($discriminatorMap, array($entityName => $map['entity']));

                $metadata->setDiscriminatorMap($discriminatorMap);
            }
        }
    }
}