<?php

namespace LightCMS\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{

    public function treeAction($style = 'nude', $idmodal = null)
    {
        $sites = $this->getDoctrine()->getRepository('LightCMSSiteBundle:Site')->findall();

        return $this->render('LightCMSSiteBundle:Site:list.html.twig', array(
            'sites' => $sites,
            'style' => $style,
            'idmodal' => $idmodal
        ));
    }

    public function viewAction($param)
    {

    }

    public function listAction()
    {
        $sites = $this->getDoctrine()->getRepository('LightCMSSiteBundle:Site')->findAll();

        return $this->render('LightCMSSiteBundle:Site:list.html.twig', array(
            'sites' => $sites
        ));
    }

    public function adminAction(Request $request, $id)
    {
        return $this->render('LightCMSSiteBundle:Site:admin.html.twig');
    }

    public function editAction(Request $request, $params)
    {

        $id = array_shift($params);
        if (is_null($id)) {
            $site = new \LightCMS\PageBundle\Entity\Site();
        } else {
            $site = $this->getDoctrine()->getRepository('LightCMSPageBundle:Site')->find($id);
        }

        if (is_null($site)) {
            return null;
        }

        $form = $this->createForm('site', $site, array(
            'action' => $this->generateUrl('light_cms_backend', array(
                'params' => '/node/create/page'
            )),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->get('submit')->isClicked()) {

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();;
                $em->persist($site);
                $em->flush();

            }
        }

        return $this->render('LightCMSPageBundle:Site:edit.html.twig', array(
            'site' => $site,
            'form' => $form->createView()));
    }

}

?>