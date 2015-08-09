<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DashboardController extends Controller
{

    public function viewAction(Request $request, $params)
    {

        return $this->render('LightCMSCoreBundle:Dashboard:view.html.twig');
    }

}
