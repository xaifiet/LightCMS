<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BackendController extends Controller
{

    public function indexAction(Request $request, $module = null, $subModule = null, $action = null, $params = null)
    {
        $user = $this->getUser();
        if (is_null($user)) {
            return $this->redirect($this->generateUrl('light_cms_backend_user_login'));
        }

        $module = is_null($module) ? 'lcms' : $module;
        $subModule = is_null($subModule) ? 'dashboard' : $subModule;
        $action = is_null($action) ? 'view' : $action;

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
