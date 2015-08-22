<?php

namespace LightCMS\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\MediaBundle\Entity\Image;

class ImageController extends Controller
{

    public function createAction(Request $request, $params)
    {
        $entity = new Image();

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSMediaBundle:Image')->find($params['id']);

        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('image', $entity, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            }

        }

        return $this->render('LightCMSMediaBundle:Image:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'action' => $action));
    }

}

?>