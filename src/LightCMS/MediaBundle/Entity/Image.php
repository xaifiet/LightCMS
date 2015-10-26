<?php

namespace LightCMS\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_media_images")
 */
class Image extends Media
{

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

//    /**
//     * @ORM\OneToOne(targetEntity="\LightCMS\CoreBundle\Entity\FileImage", cascade={"all"})
//     **/
//    private $file;

    /**
     * @ORM\ManyToMany(targetEntity="\LightCMS\CoreBundle\Entity\FileImage", cascade={"all"})
     * @ORM\JoinTable(name="lcms_media_images_scales")
     **/
    private $scales;

    /**
     * @ORM\Column(type="text")
     **/
    private $description;

    public function getInheritanceType()
    {
        return 'image';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

//    /**
//     * Set file
//     *
//     * @param \LightCMS\CoreBundle\Entity\FileImage $file
//     * @return Image
//     */
//    public function setFile(\LightCMS\CoreBundle\Entity\FileImage $file = null)
//    {
//        $this->file = $file;
//
//        return $this;
//    }
//
//    /**
//     * Get file
//     *
//     * @return \LightCMS\CoreBundle\Entity\FileImage
//     */
//    public function getFile()
//    {
//        return $this->file;
//    }

    /**
     * Add scales
     *
     * @param \LightCMS\CoreBundle\Entity\FileImage $scales
     * @return Image
     */
    public function addScale(\LightCMS\CoreBundle\Entity\FileImage $scales)
    {
        $this->scales[] = $scales;

        return $this;
    }

    /**
     * Remove scales
     *
     * @param \LightCMS\CoreBundle\Entity\FileImage $scales
     */
    public function removeScale(\LightCMS\CoreBundle\Entity\FileImage $scales)
    {
        $this->scales->removeElement($scales);
    }

    /**
     * Get scales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScales()
    {
        return $this->scales;
    }
}
