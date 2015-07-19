<?php

namespace LightCMS\CoreBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class ModuleService
{
    protected $container;

    protected $entityManager;

    protected $modules = array();

    protected $module = null;

    protected $currentId = null;


    /**
     * __construct function.
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {

        $this->container = $container;

        $this->entityManager = $container->get('doctrine.orm.entity_manager');

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
        $matches  = preg_grep ('/^light_cms_core\.backend_module\..+/i', $parametersKeys);

        // Looping on matching configurations
        foreach ($matches as $match) {

            // Looping on map name
            foreach ($parameters[$match] as $moduleName => $moduleInfo) {
                $this->modules[$moduleName] = $moduleInfo;
            }
        }

        ksort($this->modules);
    }

    public function setCurrentId($id) {
        $this->currentId = $id;
    }

    public function setModule($name)
    {
        foreach ($this->modules as $module) {

            if ($module['name'] == $name) {
                $this->module = $module;
            }
        }
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function getModule()
    {
        if (!is_null($this->module)) {
            return $this->module;
        }
        return null;
    }


    public function getModuleName()
    {
        if (!is_null($this->module)) {
            return $this->module['name'];
        }
        return null;
    }

    public function getModuleTitle()
    {
        if (!is_null($this->module)) {
            return $this->module['title'];
        }
        return null;
    }

    public function getModuleBundle()
    {
        if (!is_null($this->module)) {
            return $this->module['bundle'];
        }
        return null;
    }

    public function getModuleController()
    {
        if (!is_null($this->module)) {
            return $this->module['controller'];
        }
        return null;
    }

    public function getModuleIcon()
    {
        if (!is_null($this->module)) {
            return $this->module['icon'];
        }
        return null;
    }

    public function getEntity($entityName, $module = null)
    {
        $module = is_null($module) ? $this->module : $module;

        foreach ($module['entities'] as $name => $entity) {
            if ($name == $entityName) {
                return $entity;
            }
        }
        return null;
    }

    protected function buildTree($module, $entity, $repo, $parent, $order)
    {
        $params = isset($module['tree']['parent']) ? array($module['tree']['parent'] => $parent) : array();

        $list = $repo->findBy($params, $order);

        $res = array();

        $active = false;

        foreach ($list as $element) {
            $li = array();
            $funcId = 'get'.ucfirst($module['tree']['id']);
            $li['id'] = $element->$funcId();
            $name = array();
            foreach ($entity['name'] as $field) {
                $funcName = 'get'.ucfirst($field);
                $name[] = $element->$funcName();
            }
            $li['name'] = implode(' ', $name);
            $li['active'] = false;
            $li['current'] = $this->currentId == $li['id'] ? true : false;
            $active = $this->currentId == $li['id'] ? true : $active;
            if (isset($module['tree']['parent'])) {
                list($childActive, $li['children']) = $this->buildTree($module, $entity, $repo, $li['id'], $order);
                $active = $childActive == true ? true : $active;
                $li['active'] = $childActive == true ? true : $li['active'];
            }
            $res[] = $li;
        }

        return array($active, $res);
    }


    public function getModuleTree($module)
    {

        if (is_null($module) or !is_array($module['tree'])) {
            return array();
        }

        $entity = $this->getEntity($module['tree']['entity'], $module);

        $repo = $this->entityManager->getRepository($entity['repository']);
        $order = array();
        foreach ($entity['name'] as $field) {
            $order[$field] = 'ASC';
        }

        list($active, $res) = $this->buildTree($module, $entity, $repo, null, $order);

        return $res;
    }

}