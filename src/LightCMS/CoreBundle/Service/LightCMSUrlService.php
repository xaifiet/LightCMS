<?php

namespace LightCMS\CoreBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class LightCMSUrlService
{
    protected $container;

    protected $router;

    /**
     * __construct function.
     *
     * @access public
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {

        $this->container = $container;

        $this->router = $container->get('router');
    }

    public function generateUrl($module, $subModule, $action, $parameters)
    {

        $params = array();
        foreach ($parameters as $key => $value) {
            $params[] = $key.'/'.$value;
        }

        $routeParams = array(
            'module' => $module,
            'subModule' => $subModule,
            'action' => $action,
            'params' => implode('/', $params)
        );

        return $this->router->generate('light_cms_backend_module_action', $routeParams);

    }

}
?>