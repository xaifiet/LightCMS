<?php

namespace LightCMS\MediaBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

class LightCMSMediaExtension extends \Twig_Extension
{
    protected $container;

    /**
     * __construct function.
     *
     * @access public
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getMediaTree', array($this, 'getMediaTree')),
            new \Twig_SimpleFunction('getMediaTypes', array($this, 'getMediaTypes')),
        );
    }

    protected function getChildrenNodes(&$medias, $parentId, $list, $entity)
    {
        foreach ($list as $item) {
            $itemParentId = is_null($item->getParent()) ? null : $item->getParent()->getId();
            if ($itemParentId === $parentId) {
                $medias[] = $item;
                $this->getChildrenNodes($medias, $item->getId(), $list, $entity);
            }
        }
    }

    public function getMediaTree($entity = null) {

        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        $list = $entityManager->getRepository('LightCMSMediaBundle:Media')->findBy(array(), array('name' => 'ASC'));

        $medias = array();
        $this->getChildrenNodes($medias, null, $list, $entity);

        return $medias;
    }

    public function getMediaTypes() {

        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        $list = $entityManager->getRepository('LightCMSMediaBundle:Media')->findBy(array(), array('name' => 'ASC'));

        $medias = array();
        $this->getChildrenNodes($medias, null, $list, $entity);

        return $medias;
    }




    public function getName()
    {
        return 'lcms_media_extension';
    }
}
?>