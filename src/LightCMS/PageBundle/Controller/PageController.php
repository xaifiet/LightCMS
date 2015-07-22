<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use LightCMS\PageBundle\Entity\Page;
use LightCMS\PageBundle\Entity\Row;
use LightCMS\PageBundle\Entity\WidgetContent;

class PageController extends Controller
{

    public function viewAction($param)
    {

    }

    public function saveAction(Request $request, $form, Page $entity)
    {

        $form->handleRequest($request);

        $redirect = false;

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $rowPosition = 1;
            foreach ($entity->getRows() as $row) {
                $row->setPage($entity);
                $row->setPosition($rowPosition++);
                foreach ($row->getWidgets() as $widget) {
                    if (is_null($widget->getSize())) {
                        $widget->setSize(4);
                    }
                    $widget->setRow($row);
                }
            }

//            if ($form->get('rows_group')->get('addRow')->isClicked()) {
//
//                foreach ($entity->getRows() as $row) {
//                    $entity->addRow($row);
//                    $row->setPage($entity);
//                }
//
//                $row = new Row();
//                $row->setPage($entity);
//                $em->persist($row);
//                $em->flush();
//                $redirect = true;
//            }
//
//            foreach ($form->get('rows_group')->get('rows') as $row) {
//                if ($row->get('addWidget')->isClicked()) {
//
//                    $formRow = $row->getViewData();
//
//                    foreach ($entity->getRows() as $entityRow) {
//                        if ($entityRow->getId() == $formRow->getId()) {
//
//                            $widget = new WidgetContent();
//                            $widget->setRow($entityRow);
//                            $em->persist($widget);
//                            $em->flush();
//
//                            $entityRow->addWidget($widget);
//                            $redirect = true;
//
//                        }
//                    }
//
//                }
//            }

            if ($form->get('submit')->isClicked()) {

                $em->persist($entity);
                $em->flush();
                $redirect = true;


            }

        }

        //if ($redirect) {
        //    return $this->redirect($request->getUri());
        //}
        return $this->render('LightCMSPageBundle:Page:edit.html.twig', array(
            'form' => $form->createView(),
            'page' => $entity));
    }

}

?>