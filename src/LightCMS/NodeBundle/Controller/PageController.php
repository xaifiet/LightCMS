<?php

namespace LightCMS\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function viewAction($site, $node)
    {
        return $this->render('LightCMSNodeBundle:Page:view.html.twig', array(
            'site' => $site,
            'node' => $node
        ));
    }


    public function editAction($request, $id)
    {
        $page = $this->getDoctrine()->getRepository('LightCMSNodeBundle:Node')->find($id);

        // Form creation
        $form = $this->createForm('page', $page, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->get('submit')->isClicked()) {

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();;
                $em->persist($page);
                $em->flush();

            }
        }

        return $this->render('LightCMSNodeBundle:Page:edit.html.twig', array(
            'site' => $page,
            'form' => $form->createView()));
    }

}
