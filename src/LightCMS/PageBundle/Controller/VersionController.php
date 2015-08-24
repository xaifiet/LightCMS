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

    public function createfromPageAction(Request $request, $params)
    {
        $page = $this->getDoctrine()->getRepository('LightCMSPageBundle:Page')->find($params['id']);
        $version = $page->getPublished();

        $clone = $this->createClone($version, $page);

        return $this->redirect($this->GenerateUrl('light_cms_backend_entity_action_id', array(
            'entity' => 'version',
            'action' => 'edit',
            'id' => $clone->getId()
        )));
    }

    public function createfromversionAction(Request $request, $params)
    {
        $version = $this->getDoctrine()->getRepository('LightCMSPageBundle:Version')->find($params['id']);

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


    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSPageBundle:Version')->find($params['id']);

        if (is_null($entity)) {
            return null;
        }

        return $this->render('LightCMSPageBundle:Version:edit.html.twig', array(
            'entity' => $entity
        ));
    }


}

?>