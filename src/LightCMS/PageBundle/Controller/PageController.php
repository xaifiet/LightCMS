<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function viewAction($site, $node)
    {
        return $this->render('LightCMSPageBundle:Page:view.html.twig', array(
            'site' => $site,
            'node' => $node
        ));
    }

    public function editAction($site, $node)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        // Form creation
        $form = $this->createForm('page', $node, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));
        $form->handleRequest($request);

        return $this->render('LightCMSPageBundle:Page:edit.html.twig', array(
            'site' => $site,
            'node' => $node,
            'form' => $form->createView()));
    }

}
