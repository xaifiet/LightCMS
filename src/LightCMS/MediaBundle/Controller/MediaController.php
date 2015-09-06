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

    protected function getChildrenNodes(&$medias, $parentId, $list, $entity_id)
    {
        foreach ($list as $item) {
            if ($item->getId() == $entity_id) {
                continue;
            }
            $itemParentId = is_null($item->getParent()) ? null : $item->getParent()->getId();
            if ($itemParentId === $parentId) {
                $medias[] = $item;
                $this->getChildrenNodes($medias, $item->getId(), $list, $entity_id);
            }
        }
    }

    public function parentAction(Request $request, $params)
    {
        $list = $this->getDoctrine()->getRepository('LightCMSMediaBundle:Media')->findBy(
            array(),
            array('name' => 'ASC'));

        $medias = array();
        $this->getChildrenNodes($medias, null, $list, $params['id']);

        $media = $this->getDoctrine()->getRepository('LightCMSMediaBundle:Media')->find($params['id']);
        $parent = is_null($media) ? null : $media->getParent();

        return $this->render('LightCMSMediaBundle:Media:parent.html.twig', array(
            'medias' => $medias,
            'parent' => $parent
        ));
    }

}

?>