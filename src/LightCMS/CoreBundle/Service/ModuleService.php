<?php

namespace LightCMS\CoreBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class ModuleService
{

    protected $modules;

    protected $module;

    protected $entityManager;

    protected $currentId;


    /**
     * __construct function.
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {

        $this->entityManager = $container->get('doctrine.orm.entity_manager');

        $container->get('twig')->addGlobal('moduleService', $this);

        // Getting all symfony parameters
        $this->parameters = $container->getParameterBag()->all();

        $ps = $container->get('light_cms_core.service.parameters_service');

        $this->modules = $ps->getParameters('/^light_cms_core\.backend_module\..+/');

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

    protected function buildTree($repo, $parent, $order)
    {
        $params = isset($this->module['tree']['parent']) ? array($this->module['tree']['parent'] => $parent) : array();

        $list = $repo->findBy($params, $order);

        $res = array();

        $active = false;

        foreach ($list as $element) {
            $li = array();
            $funcId = 'get'.ucfirst($this->module['tree']['id']);
            $li['id'] = $element->$funcId();
            $funcName = 'get'.ucfirst($this->module['tree']['name']);
            $li['name'] = $element->$funcName();
            $li['active'] = false;
            $li['current'] = $this->currentId == $li['id'] ? true : false;
            $active = $this->currentId == $li['id'] ? true : $active;
            if (isset($this->module['tree']['parent'])) {
                list($childactive, $li['children']) = $this->buildTree($repo, $li['id'], $order);
                $active = $childactive == true ? true : $active;
                $li['active'] = $childactive == true ? true : $li['active'];
            }
            $res[] = $li;
        }

        return array($active, $res);
    }


    public function getModuleTree()
    {

        if (is_null($this->module) or !is_array($this->module['tree'])) {
            return array();
        }

        $repo = $this->entityManager->getRepository($this->module['tree']['repository']);
        $order = array($this->module['tree']['name'] => 'ASC');

        list($active, $res) = $this->buildTree($repo, null, $order);

        return $res;
    }

}