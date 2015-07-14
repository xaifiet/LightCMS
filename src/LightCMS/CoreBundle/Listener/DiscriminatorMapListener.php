<?php

namespace LightCMS\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * DiscriminatorMapListener class.
 *
 * This class is used to define disciminator map for entities from annotations
 * and parameters. You have to define a parameter named "discriminator_map.xxx"
 * (replace xxx by your bundle name for exemple):
 *
 * # src/Acme/DemoBundle/Resources/services.yml:
 * parameters:
 *     discriminator_map.acmedemobundle:
 *         parent:
 *             entity: Acme\DemoBundle\Entity\Parent
 *             map:
 *                 child1: Acme\DemoBundle\Entity\Child1
 *                 child2: Acme\DemoBundle\Entity\Child1
 *
 */
class DiscriminatorMapListener
{

    /**
     * mapping
     *
     * Mapping of disciminator map
     *
     * @var array
     * @access private
     */
    private $mapping = array();

    /**
     * __construct function.
     *
     * Constructing the discriminator mapping from parameters and entities:
     * - Search parameters starting with "discriminator_map"
     * - Fetching map from entities configuration
     * The Entity disciminator map has priority against parameter map
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        // Getting all symfony parameters
        $parameters = $container->getParameterBag()->all();

        // Getting all parameters keys
        $parametesKeys = array_keys($parameters);

        // Matching parameters with specific key "discriminator_map"
        $matches  = preg_grep ('/^inheritance_joined_map\..+/i', $parametesKeys);

        // Looping on matching configurations
        foreach ($matches as $match) {

            // Looping on map name
            foreach ($parameters[$match] as $ename => $parent) {

                // Looping on each map for a specific entity
                foreach ($parent['map'] as $name => $map) {

                    // Adding the map to the mapping
                    $this->mapping[$parent['entity']][$name] = $map['class'];
                }
            }
        }

        // The mapping defined in the entity has priority against parameters
        // Loop on entities in mapping to get the original mapping
        foreach (array_keys($this->mapping) as $entityName) {

            // Loop on map defined in entity
            foreach ($this->getEntityDiscriminatorMap($entityName) as $name => $map) {

                // Adding the map to the mapping
                $this->mapping[$entityName][$name] = $map;
            }
        }
    }

    /**
     * getEntityDiscriminatorMap function.
     *
     * Getting the disciminator map from entity annotation
     *
     * @access private
     * @param mixed $entity
     * @return array
     */
    private function getEntityDiscriminatorMap($entity)
    {
        // Creating a reflectin class of entity
        $reflection = new \ReflectionClass($entity);

        // Creating a AnnotationReader to read annotations
        $reader = new AnnotationReader;

        // Getting class annotation for DiscriminatorMap
        $discriminatorMapAnnotation = $reader->getClassAnnotation($reflection,
            'Doctrine\ORM\Mapping\DiscriminatorMap');

        // Returning mapping if exists
        if ($discriminatorMapAnnotation !== null) {
            return $discriminatorMapAnnotation-> value;
        }

        // Return empty array if not defined
        return array();
}

    /**
     * loadClassMetadata function.
     *
     * Event callback to send entity discriminator map from mapping
     *
     * @access public
     * @param LoadClassMetadataEventArgs $event
     * @return boolean/array
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        // Getting the metatadata from event
        $metadata = $event->getClassMetadata();

        // Getting the class from metadata
        $class = $metadata->getReflectionClass();

        // If metadata has no class, creating reflection class from class name
        if ($class === null) {
            $class = new \ReflectionClass($metadata->getName());
        }

        // Getting the class name in a string
        $classname = $class->getName();

        // If class name is in the list, return the mapping associated
        if (isset($this->mapping[$classname])) {
            return $this->mapping[$classname];
        }

        // Return false if not in list
        return false;
    }
}