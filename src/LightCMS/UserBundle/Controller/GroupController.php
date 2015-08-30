<?php

namespace LightCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\UserBundle\Entity\Group;

class GroupController extends Controller
{

    public function listAction(Request $request, $params)
    {
        $groups = $this->getDoctrine()->getRepository('LightCMSUserBundle:Group')->findBy(array(), array(
            'name' => 'ASC'
        ));

        return $this->render('LightCMSUserBundle:Group:list.html.twig', array('groups' => $groups));
    }

    public function createAction(Request $request, $params)
    {
        $entity = new Group();

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSUserBundle:Group')->find($params['id']);

        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('group', $entity, array(
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

        return $this->render('LightCMSUserBundle:Group:edit.html.twig', array(
            'form' => $form->createView(),
            'group' => $entity));
    }

}

?>