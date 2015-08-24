<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Version;

class WidgetController extends Controller
{

    public function editAction(Request $request, $params)
    {
        return $this->render('LightCMSPageBundle:Widget:edit.html.twig', array(
            'id'=> $params['id']
        ));
    }

    public function rowAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSPageBundle:Widget')->find($params['id']);

        $entities = $entity->getRow()->getVersion()->getRows();

        return $this->render('LightCMSPageBundle:Widget:row_entity.html.twig', array(
            'entities' => $entities,
            'id' => $params['id']
        ));
    }
}

?>