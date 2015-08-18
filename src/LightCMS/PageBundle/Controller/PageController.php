<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Page;
use LightCMS\PageBundle\Entity\Version;

class PageController extends Controller
{

    public function viewAction($param)
    {

    }

    public function createAction(Request $request, $params)
    {
        $entity = new Page();

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSPageBundle:Page')->find($params['id']);

        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('page', $entity, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        $redirect = false;

        if ($form->isValid()) {

            foreach ($entity->getVersions() as $version) {
                $version->setPage($entity);
                foreach ($version->getRows() as $row) {
                    $row->setVersion($version);
                    foreach ($row->getWidgets() as $widget) {
                        if (is_null($widget->getSize())) {
                            $widget->setSize(4);
                        }
                        $widget->setRow($row);
                    }
                }
            }

            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                if ($action == 'create') {
                    $version = new Version();
                    $entity->addVersion($version);
                    $version->setPage($entity);
                    $version->setNumber(1);
                    $em->persist($version);
                }
                $em->flush();
                $redirect = true;
            }

        }

        if ($redirect) {
            $lcmsUrl = $this->get('light_cms_core.service.generate_url');
            return $this->redirect($lcmsUrl->generateUrl('node', 'page', $action, array('id' => $entity->getId())));
        }
        return $this->render('LightCMSPageBundle:Page:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'action' => $action));
    }

    public function parentEntityAction(Request $request, $params)
    {
        $entities = $this->getDoctrine()->getRepository('LightCMSPageBundle:Node')->findBy(array('parent' => null));

        return $this->render('LightCMSPageBundle:Page:parent_entity.html.twig', array(
            'entities' => $entities,
            'id' => $params['id']
        ));
    }

}

?>