<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Page;
use LightCMS\PageBundle\Entity\Version;

class NodeController extends Controller
{

    public function viewAction($param)
    {

    }

    public function treeAction(Request $request)
    {
        $nodes = $this->getDoctrine()->getRepository('LightCMSPageBundle:Node')->findByParent(null);

        return $this->render('LightCMSPageBundle:Node:tree.html.twig', array('nodes' => $nodes));
    }

}

?>