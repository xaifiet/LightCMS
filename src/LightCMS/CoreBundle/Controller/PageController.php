<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function viewAction($path = null)
    {
        $siteService = $this->get('service.site');

        $home = $siteService->getHome();

        return $this->render('LightCMSCoreBundle:Default:index.html.twig', array('name' => $home->getTitle()));
    }
}
