<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_widgets")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
class Widget
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Row", inversedBy="widgets")
     **/
    private $row;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $size = 4;

    /**
     * @ORM\Column(type="integer")
     **/
    private $position = 0;

    public function __construct()
    {
        $this->id = md5(uniqid(null, true));
        $this->size = 4;
    }


    /**
     * Set id
     *
     * @param string $id
     * @return Widget
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Widget
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
     * Set position
     *
     * @param integer $position
     * @return Widget
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set row
     *
     * @param \LightCMS\PageBundle\Entity\Row $row
     * @return Widget
     */
    public function setRow(\LightCMS\PageBundle\Entity\Row $row = null)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get row
     *
     * @return \LightCMS\PageBundle\Entity\Row 
     */
    public function getRow()
    {
        return $this->row;
    }
}
