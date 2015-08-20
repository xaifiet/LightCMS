<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{

    protected function getSite(Request $request)
    {
        // Getting all available sites by priority
        $sites = $this->getDoctrine()->getRepository('LightCMSPageBundle:Site')->findBy(
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

        return $this->render('LightCMSPageBundle:Page:view.html.twig', array(
            'site' => $site,
            'breadcrumb' => $breadcrumb,
            'page' => $breadcrumb[count($breadcrumb)-1]
        ));
    }

    public function treeAction(Request $request)
    {
        $nodes = $this->getDoctrine()->getRepository('LightCMSPageBundle:Node')->findByParent(null);

        return $this->render('LightCMSPageBundle:Node:tree.html.twig', array('nodes' => $nodes));
    }
}

?>