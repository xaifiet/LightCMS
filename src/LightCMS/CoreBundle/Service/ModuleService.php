<?php

namespace LightCMS\CoreBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class ModuleService
{
    protected $container;

    protected $modules = array();

    protected $module = null;

    protected $subModule = null;

    /**
     * __construct function.
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {

        $this->container = $container;

        $container->get('twig')->addGlobal('moduleService', $this);

        $this->loadModules();
    }

    protected function loadModules()
    {

        // Getting all symfony parameters
        $parameters = $this->container->getParameterBag()->all();

        // Getting all parameters keys
        $parametersKeys = array_keys($parameters);

        // Matching parameters with specific key "discriminator_map"
        $matches  = preg_grep ('/^light_cms\.modules\..+/i', $parametersKeys);

        // Looping on matching configurations
        foreach ($matches as $match) {

            // Looping on map name
            foreach ($parameters[$match] as $moduleName => $moduleInfo) {
                if (isset($this->modules[$moduleName])) {
                    $this->modules[$moduleName] = array_replace_recursive($this->modules[$moduleName], $moduleInfo);
                } else {
                    $this->modules[$moduleName] = $moduleInfo;
                }
            }
        }

        ksort($this->modules);
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module)
    {
        if (isset($this->modules[$module])) {
            $this->module = $module;
            return true;
        }
        return false;
    }

    public function getBackController($subModule)
    {
        if (isset($this->modules[$this->module]['backend'][$subModule])) {
            return $this->modules[$this->module]['backend'][$subModule];
        }

        return null;
    }

    public function getFrontController()
    {
        if (isset($this->modules[$this->module]['frontend'])) {
            return $this->modules[$this->module]['frontend'];
        }

        return null;
    }


}