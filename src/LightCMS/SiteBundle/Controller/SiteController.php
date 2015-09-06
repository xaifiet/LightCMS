<?php

namespace LightCMS\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\SiteBundle\Entity\Site;

class SiteController extends Controller
{

    public function createAction(Request $request, $params)
    {
        $entity = new Site();

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSSiteBundle:Site')->find($params['id']);

        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('site', $entity, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            $lcmsUrl = $this->get('light_cms_core.service.generate_url');
            return $this->redirect($lcmsUrl->generateUrl('node', 'site', 'edit', array('id' => $entity->getId())));
        }

        return $this->render('LightCMSSiteBundle:Site:edit.html.twig', array(
            'form' => $form->createView(),
            'node' => $entity));
    }

    public function homeEntityAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSSiteBundle:Site')->find($params['id']);

        return $this->render('LightCMSSiteBundle:Site:home_entity.html.twig', array(
            'entity' => $entity));
    }

}

?>