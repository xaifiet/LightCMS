<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\WidgetContent;

class WidgetContentController extends Controller
{

    public function create(Request $request, $params)
    {
        $row = $this->getDoctrine()->getRepository('LightCMSPageBundle:Row')->find($params['row_id']);

        $entity = new WidgetContent();
        $entity->setRow($row);

        return $this->formAction($request, $entity, 'edit');
    }

    public function editAction(Request $request, $params)
    {
        $entity = $this->getDoctrine()->getRepository('LightCMSPageBundle:WidgetContent')->find($params['id']);

        return $this->formAction($request, $entity, 'edit');
    }

    public function formAction(Request $request, $entity, $action)
    {
        if (is_null($entity)) {
            return null;
        }

        $form = $this->createForm('widgetcontent', $entity, array(
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

        return $this->render('LightCMSPageBundle:WidgetContent:form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'action' => $action));
    }


}

?>