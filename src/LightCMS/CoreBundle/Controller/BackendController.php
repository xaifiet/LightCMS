<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BackendController extends Controller
{

    public function indexAction(Request $request, $action = 'dashboard', $module = null, $id = null)
    {
        $moduleService = $this->get('light_cms_core.service.module_service');
        $moduleService->setCurrentId($id);
        $moduleService->setModule($module);

        $moduleArray = $moduleService->getModule();

        $func = $action.'Action';
        return $this->$func($request, $moduleArray, $id);
    }


    public function viewAction(Request $request, $module = 'node', $action = 'admin', $id = null)
    {
        $moduleService = $this->get('light_cms_core.service.module_service');
        $moduleService->setCurrentId($id);
        $moduleService->setModule($module);
        if (!is_null($module)) {
            return $this->forward('LightCMSNodeBundle:Page:edit',
                array('id' => $id),
                $request->query->all());
        }

        return $this->render('LightCMSCoreBundle:Backend/default:layout.html.twig');
    }

    public function editAction(Request $request, $module, $id)
    {
        $repository = $module['entities'][$module['search_entity']]['repository'];

        $entity = $this->getDoctrine()->getRepository($repository)->find($id);

        $entityClass = get_class($entity);

        $entityName = null;
        $formType = null;
        foreach ($module['entities'] as $name => $moduleEntity) {
            if ($moduleEntity['class'] == $entityClass) {
                $entityName = $name;
                $formType = $moduleEntity['form_type'];
            }
        }

        // Form creation
        $form = $this->createForm($formType, $entity, array(
            'action' => $this->generateUrl('light_cms_core_backend', array(
                'action' => 'edit',
                'module' => $module['name'],
                'id' => $id == 'new' ? $entityName : $id
            )),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if ($form->get('submit_group')->get('submit')->isClicked()) {

                $em->persist($entity);
                $em->flush();

            } else if ($form->get('submit_group')->get('delete')->isClicked()) {
                $em->remove($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('light_cms_core_backend'));
            }

        }

        return $this->render('LightCMSCoreBundle:Backend/default:edit.html.twig', array(
            'form' => $form->createView()));
    }

    public function treeAction(Request $request, $module, $parent)
    {




    }


}
