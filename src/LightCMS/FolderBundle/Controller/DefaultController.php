<?php

namespace LightCMS\FolderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LightCMSFolderBundle:Default:index.html.twig', array('name' => $name));
    }
}
