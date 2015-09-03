<?php

namespace LightCMS\CoreBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\DependencyInjection\ContainerInterface;

use LightCMS\CoreBundle\Entity\File;

class FileEventListener
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

    protected function getFileDirectory(File $file)
    {
        return $this->getMediaDirectory().'/'.$file->getDirectory();
    }

    protected function updateFile(File $file)
    {
        if (null !== $file->file) {
            $file->setDirectory(md5(uniqid(null, true)));
            $file->setFilename($file->file->getClientOriginalName());
            $file->setMimetype($file->file->getMimeType());
            $file->setFilesize($file->file->getSize());
        }
    }

    protected function moveFile(File $file)
    {
        $file->file->move($this->getFileDirectory($file), $file->file->getClientOriginalName());

        unset($file->file);
    }

    protected function removeFile(File $file)
    {
        rrmdir($this->getFileDirectory($file));
    }

    protected function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof File)) {
            return;
        }

        $this->updateFile($file);
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof File)) {
            return;
        }

        $this->updateFile($file);
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof File)) {
            return;
        }

        $this->moveFile($file);
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof File)) {
            return;
        }

        $this->moveFile($file);
    }

    public function postRemove(LifecycleEventArgs $event)
    {
        $file = $event->getEntity();

        if (!($file instanceof File)) {
            return;
        }

        $this->removeFile($file);
    }
}