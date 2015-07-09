<?php

namespace LightCMS\FolderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_folders")
 */
class Folder extends \LightCMS\CoreBundle\Entity\Node
{

    /**
     * @ORM\Column(type="text")
     */
    private $header;

    /**
     * Set header
     *
     * @param string $header
     * @return Page
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

}
