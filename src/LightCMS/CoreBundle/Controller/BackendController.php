<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BackendController extends Controller
{

    public function viewAction(Request $request, $module = 'node', $action = 'admin', $id = null)
    {

        $moduleService = $this->get('light_cms_core.service.module_service');
        $moduleService->setCurrentId($id);
        $moduleService->setModule($module);

        $module = $moduleService->getModule();

        if (!is_null($module)) {
            return $this->forward($module['bundle'].':'.$module['controller'].':'.$action,
                array('id' => $id),
                $request->query->all());
        }

        return $this->render('LightCMSCoreBundle:Backend/default:layout.html.twig');
    }

}
