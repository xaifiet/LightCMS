<?php

namespace LightCMS\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NodeController extends Controller
{
    public function viewAction($path = null)
    {
        $siteService = $this->get('light_cms_site.service.site_service');

        $site = $siteService->getSite();

        $node = $site->getHomeNode();

        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $class = $guesser->getShortName();

        return $this->forward($bundle.':'.$class.':view', array(
            'site' => $site,
            'node' => $node,
        ));
    }

    public function adminAction($request, $id)
    {
        return $this->render('LightCMSNodeBundle:Node:admin.html.twig');
    }

    public function listAction()
    {
        $nodes = $this->getDoctrine()->getRepository('LightCMSNodeBundle:Node')->findAll();

        return $this->render('LightCMSNodeBundle:Node:list.html.twig', array(
            'nodes' => $nodes
        ));
    }

    public function editAction($request, $id)
    {
        $node = $this->getDoctrine()->getRepository('LightCMSNodeBundle:Node')->find($id);

        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $class = $guesser->getShortName();

        return $this->forward($bundle.':'.$class.':edit', array(
            'request' => $request,
            'id' => $id,
        ));
    }

}
