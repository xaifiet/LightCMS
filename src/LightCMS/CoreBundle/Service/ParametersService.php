<?php

namespace LightCMS\CoreBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class ParametersService
{

    protected $keys;

    protected $parameters;

    /**
     * __construct function.
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        // Getting all symfony parameters
        $this->parameters = $container->getParameterBag()->all();

        // Getting all parameters keys
        $this->keys = array_keys($this->parameters);
    }

    protected function keyRecursiveSort(&$array) {
        foreach ($array as &$value) {
            if (is_array($value)) $this->keyRecursiveSort($value);
        }
        return ksort($array);
    }

    public function getParameters($regexp)
    {
        $regexp = '/^'.str_replace('.', '\\.', $regexp).'\\..+/i';

        // Matching parameters with specific key "discriminator_map"
        $matches  = preg_grep ($regexp, $this->keys);

        $parameters = array();

        // Looping on matching configurations
        foreach ($matches as $match) {
            $parameters = array_replace_recursive($this->parameters[$match], $parameters);
        }

        $this->keyRecursiveSort($parameters);

        return $parameters;
    }

}