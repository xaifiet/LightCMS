<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_versions")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\HasLifecycleCallbacks()
 */
class Version
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $page;

    /**
     * @ORM\OneToMany(targetEntity="Row", mappedBy="version", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     **/
    private $rows;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rows = new ArrayCollection();
    }

    /**
     * Clone
     */
    public function __clone() {
        $this->id = null;
    }

    /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        if (!is_null($this->number) or is_null($this->page)) {
            return;
        }
        $this->number = 1;
        foreach ($this->page->getVersions() as $version) {
            if ($version->getNumber() > $this->number) {
                $this->number = $version->getNumber() + 1;
            }
        }
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
     * Set number
     *
     * @param integer $number
     * @return Version
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set page
     *
     * @param \LightCMS\PageBundle\Entity\Page $page
     * @return Version
     */
    public function setPage(\LightCMS\PageBundle\Entity\Page $page)
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
     * Add rows
     *
     * @param \LightCMS\PageBundle\Entity\Row $rows
     * @return Version
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
