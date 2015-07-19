<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_pages")
 */
class Page extends Node
{

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\Column(type="boolean")
     **/
    private $published;

    /**
     * @ORM\OneToMany(targetEntity="Row", mappedBy="page", cascade={"all"}, orphanRemoval=true)
     **/
    private $rows;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->rows = new ArrayCollection();
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Page
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Page
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Add rows
     *
     * @param \LightCMS\PageBundle\Entity\Row $rows
     * @return Page
     */
    public function addRow(\LightCMS\PageBundle\Entity\Row $rows)
    {
        $this->rows[] = $rows;

        return $this;
    }

    /**
     * Remove rows
     *
     * @param \LightCMS\PageBundle\Entity\Row $rows
     */
    public function removeRow(\LightCMS\PageBundle\Entity\Row $rows)
    {
        $this->rows->removeElement($rows);
    }

    /**
     * Get rows
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRows()
    {
        return $this->rows;
    }
}
