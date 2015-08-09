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
     * @ORM\OneToOne(targetEntity="Version")
     **/
    private $published;

    /**
     * @ORM\OneToMany(targetEntity="Version", mappedBy="page", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"number" = "ASC"})
     **/
    private $versions;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->versions = new ArrayCollection();
    }

    public function getInheritanceType()
    {
        return 'page';
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
     * @param \LightCMS\PageBundle\Entity\Version $published
     * @return Page
     */
    public function setPublished(\LightCMS\PageBundle\Entity\Version $published = null)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \LightCMS\PageBundle\Entity\Version 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Add versions
     *
     * @param \LightCMS\PageBundle\Entity\Version $versions
     * @return Page
     */
    public function addVersion(\LightCMS\PageBundle\Entity\Version $versions)
    {
        $this->versions[] = $versions;

        return $this;
    }

    /**
     * Remove versions
     *
     * @param \LightCMS\PageBundle\Entity\Version $versions
     */
    public function removeVersion(\LightCMS\PageBundle\Entity\Version $versions)
    {
        $this->versions->removeElement($versions);
    }

    /**
     * Get versions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVersions()
    {
        return $this->versions;
    }
}
