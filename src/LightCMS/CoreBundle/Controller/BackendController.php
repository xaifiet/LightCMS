<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function viewAction(Request $request, $module = 'node', $action = 'admin', $id = null)
    {

        $ps = $this->get('light_cms_core.service.parameters_service');

        $params = $ps->getParameters('/^light_cms_core\.backend\.module\..+/');

        foreach ($params as $param) {

            if ($param['module'] == $module) {
                $body = $this->forward($param['controller'].':'.$action, array('id' => $id), $request->query->all());
                $side = $this->forward($param['controller'].':list', array('id' => $id), $request->query->all());

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
