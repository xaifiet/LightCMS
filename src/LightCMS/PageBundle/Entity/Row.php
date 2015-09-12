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
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="VersionRows", inversedBy="rows")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $version;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

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
        $this->widgets = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Row
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
     * @param \LightCMS\PageBundle\Entity\VersionRows $version
     * @return Row
     */
    public function setVersion(\LightCMS\PageBundle\Entity\VersionRows $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return \LightCMS\PageBundle\Entity\VersionRows
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
