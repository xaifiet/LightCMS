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
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="rows")
     * @ORM\JoinColumn(name="parent", referencedColumnName="salt", nullable=false)
     **/
    private $page;

    /**
     * @ORM\OneToMany(targetEntity="Widget", mappedBy="row", cascade={"all"}, orphanRemoval=true)
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
     * Set page
     *
     * @param \LightCMS\PageBundle\Entity\Page $page
     * @return Row
     */
    public function setPage(\LightCMS\PageBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \LightCMS\PageBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
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
