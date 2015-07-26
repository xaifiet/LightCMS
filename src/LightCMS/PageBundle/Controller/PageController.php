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

    public function createAction(Request $request, $id)
    {
        $entity = new Page();

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $id)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSPageBundle:Page')->find($id);

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
            return $this->redirect($this->GenerateUrl('light_cms_backend_entity_action_id', array(
                'entity' => 'page',
                'action' => 'edit',
                'id' => $entity->getId()
            )));
        }
        return $this->render('LightCMSPageBundle:Page:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'action' => $action));
    }


}

?>