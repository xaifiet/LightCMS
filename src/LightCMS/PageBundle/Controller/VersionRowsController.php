<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\VersionRows;

class VersionRowsController extends Controller
{

    public function viewAction(Request $request, Site $site, $breadcrumb, Page $page, VersionHeader $version)
    {


        return $this->render('LightCMSPageBundle:VersionRows:view.html.twig', array(
            'site' => $site,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'version' => $version
        ));
    }

    public function createAction(Request $request, $params)
    {
        $page = $this->getDoctrine()->getRepository('LightCMSPageBundle:Page')->find($params['id']);
        $entity = new VersionRows();
        $entity->setPage($page);

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $entity)
    {
        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('versionrows', $entity, array(
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
            return $this->redirect($lcmsUrl->generateUrl('node', 'version', 'edit', array(
                'id' => $entity->getId()
            )));
        }

        return $this->render('LightCMSPageBundle:VersionRows:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'node' => $entity->getPage()
        ));
    }

}

?>