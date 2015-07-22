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
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Row", inversedBy="widgets")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     **/
    private $row;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $size = 4;


    public function __construct()
    {
        $this->size = 4;
    }

    /**
     * Get id
     *
     * @return integer 
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
