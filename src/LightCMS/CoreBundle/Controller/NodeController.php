<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodeController extends Controller
{
    public function viewAction($path = null)
    {
        $siteService = $this->get('lcms_site');

        $site = $siteService->getSite();

        $node = $site->getNode();

        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $class = $guesser->getShortName();

        $this->get('twig')->addGlobal('siteService', $siteService);

        return $this->forward($bundle.':'.$class.':view', array(
            'site' => $site,
            'node' => $node,
        ));
    }

    public function editAction($path = null)
    {
        $siteService = $this->get('lcms_site');

        $site = $siteService->getSite();

        $node = $site->getNode();

        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $class = $guesser->getShortName();

        $this->get('twig')->addGlobal('siteService', $siteService);

        return $this->forward($bundle.':'.$class.':edit', array(
            'site' => $site,
            'node' => $node,
        ));
    }

}
