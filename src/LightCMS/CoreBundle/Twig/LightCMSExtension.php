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

    public function pathFunction($params = array())
    {
        $router = $this->container->get('router');

        $routeParams = array();
        $viewParams = array();
        foreach ($params as $key => $value) {
            if (in_array($key, array('module', 'subModule', 'action'))) {
                $routeParams[$key] = $value;
            } else {
                $viewParams[] = $key.'/'.$value;
            }
        }
        $routeParams['params'] = implode('/', $viewParams);


        return $router->generate('light_cms_backend_module_action', $routeParams);
    }

    public function getName()
    {
        return 'lcms_extension';
    }
}
?>