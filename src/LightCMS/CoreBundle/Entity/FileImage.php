<?php

namespace LightCMS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_files_images")
 * @ORM\HasLifecycleCallbacks()
 */
class FileImage extends File
{

    /**
     * @ORM\Column(type="string", length=40, nullable=false)
     */
    private $size;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $height;

    /**
     * @Assert\File(maxSize="15000000")
     */
    public $file;

    /**
     * Set size
     *
     * @param string $size
     * @return FileImage
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return FileImage
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return FileImage
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }
}
