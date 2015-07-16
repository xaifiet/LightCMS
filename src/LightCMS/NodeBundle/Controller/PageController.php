<?php

namespace LightCMS\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\NodeBundle\Entity\Page;

class PageController extends Controller
{
    public function viewAction($site, $node)
    {
        return $this->render('LightCMSNodeBundle:Page:view.html.twig', array(
            'site' => $site,
            'node' => $node
        ));
    }

    public function editAction(Request $request, $id)
    {
        if ($id == 'new') {
            $page = new Page();
        } else {
            $page = $this->getDoctrine()->getRepository('LightCMSNodeBundle:Node')->find($id);
        }

        // Form creation
        $form = $this->createForm('page', $page, array(
            'action' => $this->generateUrl('light_cms_core_backend', array(
                'module' => 'node',
                'action' => $id == 'new' ? 'create' : 'edit',
                'id' => $id == 'new' ? 'page' : $id
            )),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if ($form->get('submit')->isClicked()) {

                $em->persist($page);
                $em->flush();

                return $this->redirect($this->generateUrl('light_cms_core_backend', array(
                    'module' => 'node',
                    'action' => 'edit',
                    'id' => $page->getSalt()
                )));

            } else if ($form->get('delete')->isClicked()) {
                $em->remove($page);
                $em->flush();

                return $this->redirect($this->generateUrl('light_cms_core_backend'));
            }

        }
        return $this->render('LightCMSNodeBundle:Page:edit.html.twig', array(
            'site' => $page,
            'form' => $form->createView()));
    }

}
