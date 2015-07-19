<?php

namespace LightCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BackendController extends Controller
{

    protected $moduleService;

    protected $module;

    protected $param;

    public function indexAction(Request $request, $action = 'dashboard', $module = 'dashboard', $id = null)
    {
        $this->moduleService = $this->get('light_cms_core.service.module_service');
        $this->moduleService->setCurrentId($id);
        $this->moduleService->setModule($module);
        $this->module = $this->moduleService->getModule();

        $this->param = $id;

        $func = $action.'Action';
        return $this->$func($request);
    }

    public function dashboardAction(Request $request)
    {

        return $this->render('LightCMSCoreBundle:Backend:dashboard.html.twig');
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

    public function createAction(Request $request)
    {
        $entityInfo = $this->moduleService->getEntity($this->param);

        $entity = new $entityInfo['class']();

        return $this->formAction($request, 'create', $entityInfo, $entity, $this->param);
    }

    public function editAction(Request $request)
    {
        $entitySearch = $this->module['entities'][$this->module['search_entity']];

        $repository = $entitySearch['repository'];

        $entity = $this->getDoctrine()->getRepository($repository)->find($this->param);

        $entityClass = get_class($entity);
        $entityInfo = null;
        foreach ($this->module['entities'] as $name => $moduleEntity) {
            if ($moduleEntity['class'] == $entityClass) {
                $entityInfo = $moduleEntity;
            }
        }

        return $this->formAction($request, 'edit', $entityInfo, $entity, $this->param);
    }

    public function formAction(Request $request, $action, $entityInfo, $entity, $param)
    {

        // Form creation
        $form = $this->createForm($entityInfo['form']['type'], $entity, array(
            'action' => $this->generateUrl('light_cms_core_backend', array(
                'action' => $action,
                'module' => $this->module['name'],
                'id' => $param
            )),
            'method' => 'POST'
        ));

        if (isset($entityInfo['form']['save'])) {
            return $this->forward($entityInfo['form']['save'], array(
                'request' => $request,
                'form' => $form,
                'entity' => $entity
            ));
        }

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

        return $this->render('LightCMSCoreBundle:Backend:edit.html.twig', array(
            'form' => $form->createView()));


    }

    public function treeAction(Request $request, $module, $parent)
    {




    }


}
