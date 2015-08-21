<?php

namespace LightCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\UserBundle\Entity\User;

class UserController extends Controller
{

    public function dashboardAction(Request $request, $params)
    {
        $users = $this->getDoctrine()->getRepository('LightCMSUserBundle:User')->findBy(array(), array(
            'lastname' => 'ASC',
            'firstname' => 'ASC'
        ));

        return $this->render('LightCMSUserBundle:User:dashboard.html.twig', array('users' => $users));
    }

    public function createAction(Request $request, $params)
    {
        $entity = new User();

        return $this->formAction($request, $entity, 'create');
    }


    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSUserBundle:User')->find($params['id']);

        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('user', $entity, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        $redirect = false;

        if ($form->isValid()) {

            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $redirect = true;
            }

        }

        return $this->render('LightCMSUserBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'action' => $action));
    }

    public function treeAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('LightCMSUserBundle:User')->findBy(array(), array(
            'lastname' => 'ASC',
            'firstname' => 'ASC'
        ));

        return $this->render('LightCMSUserBundle:User:tree.html.twig', array('users' => $users));
    }
}

?>