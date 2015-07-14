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

        $twig = $this->get('twig');

        foreach ($parameters as $parameter) {

            if ($parameter['module'] == $module) {
                $body = $this->forward($parameter['controller'].':'.$action, array(
                    'request' => $this->getRequest(),
                    'id' => $id));
                $side = $this->forward($parameter['controller'].':list', array(
                    'request' => $this->getRequest(),
                    'id' => $id));

                return $this->render('LightCMSCoreBundle:Backend/default:layout.html.twig', array(
                    'side' => $side->getContent(),
                    'body' => $body->getContent(),
                    'id' => $id
                ));
            }
        }

        return $this->render('LightCMSCoreBundle:Backend/default:layout.html.twig');
    }

}
