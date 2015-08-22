<?php

namespace LightCMS\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller
{

    public function dashboardAction(Request $request, $params)
    {
        $parent = isset($params['id']) ? $params['id'] : null;

        $medias = $this->getDoctrine()->getRepository('LightCMSMediaBundle:Media')->findBy(
            array(
                'parent' => $parent
            ),
            array(
                'name' => 'ASC'
            )
        );

        return $this->render('LightCMSMediaBundle:Media:list.html.twig', array('medias' => $medias));
    }

    public function parentAction(Request $request, $params)
    {
        $entities = $this->getDoctrine()->getRepository('LightCMSMediaBundle:Media')->findBy(array('parent' => null));

        return $this->render('LightCMSMediaBundle:Media:parent.html.twig', array(
            'entities' => $entities,
            'id' => $params['id']
        ));
    }
}

?>