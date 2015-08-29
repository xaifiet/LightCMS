<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Page;

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

            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $redirect = true;
            }

        }

        if ($redirect) {
            $lcmsUrl = $this->get('light_cms_core.service.generate_url');
            return $this->redirect($lcmsUrl->generateUrl('node', 'page', 'edit', array(
                'id' => $entity->getId()
            )));
        }

        return $this->render('LightCMSPageBundle:Page:edit.html.twig', array(
            'form' => $form->createView(),
            'node' => $entity
        ));
    }

    protected function getChildrenNodes(&$nodes, $parentId, $list, $entity_id)
    {
        foreach ($list as $item) {
            if ($item->getId() == $entity_id) {
                continue;
            }
            $itemParentId = is_null($item->getParent()) ? null : $item->getParent()->getId();
            if ($itemParentId === $parentId) {
                $nodes[] = $item;
                $this->getChildrenNodes($nodes, $item->getId(), $list, $entity_id);
            }
        }
        return $nodes;
    }

    public function parentEntityAction(Request $request, $params)
    {
        $list = $this->getDoctrine()->getRepository('LightCMSCoreBundle:Node')->findBy(
            array(),
            array('name' => 'ASC'));

        $nodes = array();
        $this->getChildrenNodes($nodes, null, $list, $params['id']);

        $node = $this->getDoctrine()->getRepository('LightCMSCoreBundle:Node')->find($params['id']);
        $parent = is_null($node) ? null : $node->getParent();

        return $this->render('LightCMSPageBundle:Page:parent_entity.html.twig', array(
            'nodes' => $nodes,
            'parent' => $parent
        ));
    }

}

?>