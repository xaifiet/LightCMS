<?php

namespace LightCMS\SiteBundle\Controller;

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

    public function editAction(Request $request, $id)
    {
        if ($id == 'new') {
            $site = new \LightCMS\SiteBundle\Entity\Site();
        } else {
            $site = $this->getDoctrine()->getRepository('LightCMSSiteBundle:Site')->find($id);
        }

        // Form creation
        $form = $this->createForm('site', $site, array(
            'action' => $request->getUri(),
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

        return $this->render('LightCMSSiteBundle:Site:edit.html.twig', array(
            'site' => $site,
            'form' => $form->createView()));
    }

}

?>