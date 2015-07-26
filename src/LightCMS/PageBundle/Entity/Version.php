<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_versions")
 */
class Version
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
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
        $this->id = md5(uniqid(null, true));
        $this->rows = new ArrayCollection();
    }

    /**
     * Clone
     */
    public function __clone() {
        $this->id = md5(uniqid(null, true));
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
     * Set published
     *
     * @param boolean $published
     * @return Version
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

    /**
     * Set id
     *
     * @param string $id
     * @return Version
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
