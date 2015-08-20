<?php

namespace LightCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    public function frontAction(Request $request)
    {
        return $this->render('LightCMSUserBundle:Login:front.html.twig');
    }

    public function backAction(Request $request)
    {
        return $this->render('LightCMSUserBundle:Login:back.html.twig');
    }

}
