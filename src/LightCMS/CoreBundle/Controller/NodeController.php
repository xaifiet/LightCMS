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


        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $layout = $guesser->guessEntityShortName();

        $extendLayout = 'LightCMSCoreBundle:Layout/'.$site->getLayout();

        return $this->render($bundle.':'.$layout.':view.html.twig', array(
            'extendTemplate' => $extendLayout.':layout.html.twig',
            'site' => $site,
            'node' => $node
        ));
    }
}
