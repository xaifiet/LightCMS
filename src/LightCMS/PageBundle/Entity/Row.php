<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_rows")
 */
class Row
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Version", inversedBy="rows")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $version;

    /**
     * @ORM\Column(type="integer")
     **/
    private $position = 0;

    /**
     * @ORM\OneToMany(targetEntity="Widget", mappedBy="row", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     **/
    private $widgets;

    /**
     * __construct function.
     *
     * @access public
     */
    public function __construct() {
        $this->id = md5(uniqid(null, true));
        $this->widgets = new ArrayCollection();
    }


    /**
     * Set id
     *
     * @param string $id
     * @return Row
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
     * Set position
     *
     * @param integer $position
     * @return Row
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
     * Set version
     *
     * @param \LightCMS\PageBundle\Entity\Version $version
     * @return Row
     */
    public function setVersion(\LightCMS\PageBundle\Entity\Version $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return \LightCMS\PageBundle\Entity\Version 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Add widgets
     *
     * @param \LightCMS\PageBundle\Entity\Widget $widgets
     * @return Row
     */
    public function addWidget(\LightCMS\PageBundle\Entity\Widget $widgets)
    {
        $this->widgets[] = $widgets;

        return $this;
    }

    /**
     * Remove widgets
     *
     * @param \LightCMS\PageBundle\Entity\Widget $widgets
     */
    public function removeWidget(\LightCMS\PageBundle\Entity\Widget $widgets)
    {
        $this->widgets->removeElement($widgets);
    }

    /**
     * Get widgets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidgets()
    {
        return $this->widgets;
    }
}
