<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class BackendController extends Controller
{

    public function indexAction(Request $request, $module = null, $subModule = null, $action = null, $params = null)
    {
        $module = is_null($module) ? 'lcms' : $module;
        $subModule = is_null($subModule) ? 'dashboard' : $subModule;
        $action = is_null($action) ? 'view' : $action;

        $moduleService = $this->get('light_cms_core.service.module_service');

        $moduleService->setModule($module);
        $moduleService->setSubModule($subModule);

        $bundleController = $moduleService->getCurrentController();

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
