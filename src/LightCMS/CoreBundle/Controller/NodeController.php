<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodeController extends Controller
{
    public function viewAction($path = null)
    {
        $siteService = $this->get('service.site');

        $site = $siteService->getSite();

        $node = $site->getNode();

        $bundle = 'LightCMSCoreBundle';
        $layout = 'Layout/'.$site->getLayout();

        var_dump(get_class($node));

        return $this->render($bundle.':'.$layout.':layout.html.twig', array(
            'site' => $site,
            'node' => $node
        ));
    }
}
