<?php

namespace LightCMS\NodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{

    protected function getModules()
    {
        $list = $this->get('light_cms_core.service.parameters_service')
                     ->getParameters('/^inheritance_joined_map\..+/');

        $modules = array();

        foreach ($list as $inheritance) {
            foreach ($inheritance as $entity) {
                if ($entity['entity'] != 'LightCMS\\NodeBundle\\Entity\\Node') {
                    continue;
                }
                foreach ($entity['map'] as $name => $module) {
                    $modules[$name] = $module;
                }
            }
        }
        return $modules;
    }

    public function viewAction($path = null)
    {
        $siteService = $this->get('light_cms_site.service.site_service');

        $site = $siteService->getSite();

        $node = $site->getHomeNode();

        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $class = $guesser->getShortName();

        return $this->forward($bundle.':'.$class.':view', array(
            'site' => $site,
            'node' => $node,
        ));
    }

    public function adminAction(Request $request, $id)
    {
        return $this->render('LightCMSNodeBundle:Node:admin.html.twig');
    }

    public function listAction()
    {
        $nodes = $this->getDoctrine()->getRepository('LightCMSNodeBundle:Node')->findByParent(null);

        return $this->render('LightCMSNodeBundle:Node:list.html.twig', array(
            'nodes' => $nodes
        ));
    }

    public function createAction(Request $request, $id)
    {
        $modules = $this->getModules();

        foreach ($modules as $name => $module) {
            if ($id == $name) {
                return $this->forward($module['controller'].':edit', array(
                    'request' => $request,
                    'id' => 'new',
                ));
            }
        }

        return $this->render('LightCMSNodeBundle:Node:create.html.twig', array(
            'modules' => $modules
        ));
    }

    public function editAction(Request $request, $id)
    {
        $node = $this->getDoctrine()->getRepository('LightCMSNodeBundle:Node')->find($id);

        $guesser = $this->get('class_guesser')->getGuesser($node);

        $bundle = $guesser->getBundleShortName();
        $class = $guesser->getShortName();

        return $this->forward($bundle.':'.$class.':edit', array(
            'request' => $request,
            'id' => $id,
        ));
    }

}
