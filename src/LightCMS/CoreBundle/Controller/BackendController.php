<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BackendController
 *
 * @package LightCMS\CoreBundle\Controller
 */
class BackendController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($module = 'node', $action = 'admin', $id = null)
    {

        $ps = $this->get('light_cms_core.service.parameters_service');

        $parameters = $ps->getParameters('/^light_cms_core\.backend\.module\..+/');

        foreach ($parameters as $parameter) {

            if ($parameter['module'] == $module) {
                return $this->render('LightCMSCoreBundle:Backend/default:layout.html.twig', array(
                    'sideController' => $parameter['controller'].':list',
                    'bodyController' => $parameter['controller'].':'.$action,
                    'id' => $id
                ));
            }
        }

        return $this->render('LightCMSCoreBundle:Backend/default:layout.html.twig');
    }

}
