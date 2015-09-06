<?php

namespace LightCMS\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_media_folders")
 */
class Folder extends Media
{

    public function getInheritanceType()
    {
        return 'folder';
    }

}
