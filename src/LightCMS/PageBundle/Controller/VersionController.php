<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Version;

class VersionController extends Controller
{

    public function viewAction($param)
    {

    }

    public function createfromPageAction(Request $request, $id)
    {
        $page = $this->getDoctrine()->getRepository('LightCMSPageBundle:Page')->find($id);
        $version = $page->getPublished();

        $clone = $this->createClone($version, $page);

        return $this->redirect($this->GenerateUrl('light_cms_backend_entity_action_id', array(
            'entity' => 'version',
            'action' => 'edit',
            'id' => $clone->getId()
        )));
    }

    public function createfromversionAction(Request $request, $id)
    {
        $version = $this->getDoctrine()->getRepository('LightCMSPageBundle:Version')->find($id);

        $clone = $this->createClone($version, $version->getPage());

        return $this->redirect($this->GenerateUrl('light_cms_backend_entity_action_id', array(
            'entity' => 'version',
            'action' => 'edit',
            'id' => $clone->getId()
        )));
    }

    protected function createClone($model, $page)
    {
        if (is_null($model)) {
            if (is_null($page)) {
                return null;
            }
            $clone = new Version();
            $clone->setPage($page);
        } else {
            $clone = clone $model;
        }

        $number = 1;
        foreach ($page->getVersions() as $pageVersion) {
            if ($number <= $pageVersion->getNumber()) {
                $number = $pageVersion->getNumber() + 1;
            }
        }
        $clone->setNumber($number);

        $entityManager = $this->getDoctrine()->getEntityManager();
        $entityManager->detach($clone);
        $entityManager->persist($clone);
        $entityManager->flush();

        return $clone;
    }


    public function editAction(Request $request, $id)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSPageBundle:Version')->find($id);

        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('version', $entity, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        $redirect = false;

        if ($form->isValid()) {


            foreach ($entity->getRows() as $row) {
                $row->setVersion($entity);
                foreach ($row->getWidgets() as $widget) {
                    if (is_null($widget->getSize())) {
                        $widget->setSize(4);
                    }
                    $widget->setRow($row);
                }
            }

            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $redirect = true;
            }

        }

        if ($redirect) {
            return $this->redirect($this->GenerateUrl('light_cms_backend_entity_action_id', array(
                'entity' => 'version',
                'action' => 'edit',
                'id' => $entity->getId()
            )));
        }
        return $this->render('LightCMSPageBundle:Version:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity));
    }


}

?>