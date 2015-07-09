<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LightCMSPageBundle:Default:index.html.twig', array('name' => $name));
    }
}
