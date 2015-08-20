<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{

    public function viewAction(Request $request, $path = null)
    {
        $moduleService = $this->get('light_cms_core.service.module_service');

        $path = explode('/', trim($path, '/'));
        $module = count($path) > 0 ? $path[0] : null;
        if (!$moduleService->setModule($module)) {
            $moduleService->setModule('node');
        } else {
            array_shift($path);
        }

        $controller = $moduleService->getFrontController();

        return $this->forward($controller, array(
            'request' => $request,
            'path' => array_filter($path)
        ));
    }

}
