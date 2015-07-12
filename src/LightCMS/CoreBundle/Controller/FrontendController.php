<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    public function viewAction($module = null, $path = null)
    {
        $siteService = $this->get('light_cms_site.service.site_service');

        $site = $siteService->getSite();

        $ps = $this->get('light_cms_core.service.parameters_service');

        $parameters = $ps->getParameters('/^light_cms_core\.backend\.module\..+/');

        foreach ($parameters as $parameter) {

            if ($parameter['module'] == $module) {
                return $this->render('LightCMSCoreBundle:Frontend/default:layout.html.twig', array(
                    'site' => $site,
                    'bodyController' => $parameter['controller'].':view',
                    'path' => $path,
                ));
            }
        }

        return $this->render('LightCMSCoreBundle:Frontend/default:layout.html.twig',array(
            'site' => $site,
            'bodyController' => 'LightCMSNodeBundle:Node:view',
            'path' => $module.'/'.$path
        ));
    }

}
