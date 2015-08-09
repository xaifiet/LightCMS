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
        );
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