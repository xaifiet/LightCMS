<?php

namespace LightCMS\CoreBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\DependencyInjection\ContainerInterface;

use LightCMS\CoreBundle\Entity\FileImage;

class FileImageEventListener
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getMediaDirectory()
    {
        return $this->container->getParameter('media_directory');
    }

    protected function getFilePath(FileImage $file)
    {
        return $this->getMediaDirectory().'/'.$file->getDirectory().'/'.$file->getFilename();
    }

    protected function updateFile(FileImage $file)
    {
        if (null !== $file->file) {
            list($width, $height, $type, $attr) = getimagesize($file->file->getRealPath());

            $file->setHeight($height);
            $file->setWidth($width);
            if (empty($file->getSize())) {
                $file->setSize($width . 'x' . $height);
            }
        }
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof FileImage)) {
            return;
        }

        $this->updateFile($file);
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof FileImage)) {
            return;
        }

        $this->updateFile($file);
    }

}