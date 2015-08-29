<?php

namespace LightCMS\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

class LightCMSExtension extends \Twig_Extension
{
    protected $container;

    /**
     * __construct function.
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('lcmspath', array($this, 'pathFunction')),
            new \Twig_SimpleFunction('lcmsjs', array($this, 'getJavascriptFunction')),
            new \Twig_SimpleFunction('lcmscss', array($this, 'getStylesheetFunction')),
            new \Twig_SimpleFunction('getController', array($this, 'getController')),
            new \Twig_SimpleFunction('getNodeTree', array($this, 'getNodeTree')),
        );
    }

    protected function getAsset($name, $block, $global = true)
    {
        $parameterService = $this->container->get('light_cms_core.service.parameters_service');

        $javaScripts = $parameterService->getParameters('light_cms.'.$name);

        $blocks = array($global ? 'global' : null, $block);

        $res = array();
        foreach ($blocks as $block)
            if (isset($javaScripts[$block])) {
                $res = array_merge($res, $javaScripts[$block]);
            }

        return $res;

    }

    public function getJavascriptFunction($block, $global = true)
    {
        return $this->getAsset('javascript', $block, $global);
    }

    public function getStylesheetFunction($block, $global = true)
    {
        return $this->getAsset('stylesheet', $block, $global);
    }

    public function pathFunction($module, $subModule, $action, $params = array())
    {
        $lcmsUrl = $this->container->get('light_cms_core.service.generate_url');

        return $lcmsUrl->generateUrl($module, $subModule, $action, $params);
    }

    public function getController($module, $subModule, $view)
    {
        $parameterService = $this->container->get('light_cms_core.service.parameters_service');

        $parameters = $parameterService->getParameters('light_cms.inheritance');

        if (isset($parameters[$module][$subModule]['controllers'][$view])) {
            return $parameters[$module][$subModule]['controllers'][$view];
        }

        return null;
    }

    protected function getChildrenNodes(&$nodes, $parentId, $list, $entity)
    {

        foreach ($list as $item) {
            $itemParentId = is_null($item->getParent()) ? null : $item->getParent()->getId();
            if ($itemParentId === $parentId) {
                $nodes[] = $item;
                $this->getChildrenNodes($nodes, $item->getId(), $list, $entity);
            }
        }
        return $nodes;
    }


    public function getNodeTree($entity = null) {

        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        $list = $entityManager->getRepository('LightCMSCoreBundle:Node')->findBy(array(), array('name' => 'ASC'));

        $nodes = array();
        $this->getChildrenNodes($nodes, null, $list, $entity);

        return $nodes;
    }


    public function getName()
    {
        return 'lcms_extension';
    }
}
?>