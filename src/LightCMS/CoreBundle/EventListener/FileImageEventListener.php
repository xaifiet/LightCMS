<?php

namespace LightCMS\CoreBundle\EventListener;

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
            $size = getimagesize($file->file->getRealPath());

            $file->setHeight($size[1]);
            $file->setWidth($size[0]);
            if (empty($file->getSize())) {
                $file->setSize($size[0] . 'x' . $size[1]);
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