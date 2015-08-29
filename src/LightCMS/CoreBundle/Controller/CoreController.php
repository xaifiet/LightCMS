<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CoreController extends Controller
{

    public function frontendAction(Request $request, $path = null)
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

    public function backendAction(Request $request, $module = null, $subModule = null, $action = null, $params = null)
    {
        $user = $this->getUser();
        if (is_null($user)) {
            return $this->redirect($this->generateUrl('light_cms_backend_user_login'));
        }

        $module = is_null($module) ? 'node' : $module;
        $subModule = is_null($subModule) ? 'node' : $subModule;
        $action = is_null($action) ? 'list' : $action;

        $moduleService = $this->get('light_cms_core.service.module_service');

        $moduleService->setModule($module);

        $bundleController = $moduleService->getBackController($subModule);

        $tabParams = explode('/', $params);
        $controllerParams = array();
        while (count($tabParams) > 0) {
            $controllerParams[array_shift($tabParams)] = array_shift($tabParams);
        }

        return $this->forward($bundleController.':'.$action, array(
            'request' => $request,
            'params' => $controllerParams
        ));
    }

}
