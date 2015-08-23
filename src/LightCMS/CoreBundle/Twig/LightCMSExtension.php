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

    public function getName()
    {
        return 'lcms_extension';
    }
}
?>