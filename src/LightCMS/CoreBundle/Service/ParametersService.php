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

    public function getParameters($regexp)
    {



        // Matching parameters with specific key "discriminator_map"
        $matches  = preg_grep ($regexp, $this->keys);

        $parameters = array();

        // Looping on matching configurations
        foreach ($matches as $match) {
            $parameters[$match] = $this->parameters[$match];
        }

        return $parameters;
    }

}