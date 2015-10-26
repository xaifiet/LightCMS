<?php

namespace LightCMS\MediaBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\DependencyInjection\ContainerInterface;

use LightCMS\MediaBundle\Entity\Media;

class MediaEventListener
{

    protected $container;

    protected $encoderFactory;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $media = $event->getEntity();

        if (!($media instanceof Media)) {
            return;
        }

        if (is_null($media->getName())) {

            $media->setName($media->getFile()->file->getClientOriginalName());

        }
        if (is_null($media->getTitle())) {

            $media->setTitle($media->getFile()->file->getClientOriginalName());

        }

    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $media = $event->getEntity();

        if (!($media instanceof Media)) {
            return;
        }

        if (is_null($media->getName())) {

            $media->setName($media->getFile()->getFilename());

        }

    }
}