<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Page;

class PageController extends Controller
{

    /*
     * Frontend Part
     */

    protected function getSite(Request $request)
    {
        // Getting all available sites by priority
        $sites = $this->getDoctrine()->getRepository('LightCMSSiteBundle:Site')->findBy(
            array(),
            array('priority' => 'ASC')
        );

        // Loop on sites
        foreach ($sites as $site) {

            // Preparing regexp for matching
            $regexp = '/'.str_replace('*', '.+', $site->getHost()).'/';

            // Check the regexp and return Site if matching
            if (preg_match($regexp, $request->getHost())) {
                return $site;
            }
        }

        return null;

    }

    protected function getBreadcrumb($node, $path)
    {
        $child = $this->getDoctrine()->getRepository('LightCMSPageBundle:Page')->findOneBy(array(
            'parent' => $node,
            'url' => array_shift($path)
        ));

        if (is_null($child) or is_null($child->getPublished())) {
            throw $this->createNotFoundException('Page does not exist');
        }
        $res = array($child);
        if (count($path) > 0) {
            $res = array_merge($res, $this->getBreadcrumb($child, $path));
        }

        return $res;
    }

    public function viewAction(Request $request, $path)
    {
        $site = $this->getSite($request);

        if (count($path) > 0) {
            $breadcrumb = $this->getBreadcrumb($site, $path);
        } else {
            $page = $site->getHome();
            if (is_null($page) or is_null($page->getPublished())) {
                throw $this->createNotFoundException('Page does not exist');
            }
            $breadcrumb = array($page);
        }

        return $this->forward('LightCMSPageBundle:Version:view', array(
            'request' => $request,
            'site' => $site,
            'breadcrumb' => $breadcrumb,
            'page' => $breadcrumb[count($breadcrumb)-1]
        ));
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