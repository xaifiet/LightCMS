<?php

namespace LightCMS\NodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_nodes_folders")
 */
class Folder extends Node
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
