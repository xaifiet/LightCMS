<?php

namespace LightCMS\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_medias")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="\LightCMS\CoreBundle\Entity\File", cascade={"all"})
     **/
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="children")
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Media", mappedBy="parent", cascade={"all"})
     **/
    private $children;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * __construct function.
     *
     * @access public
     */
    public function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        $this->updated = new \DateTime();
        if (is_null($this->created)) {
            $this->created = $this->updated;
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
     * Set name
     *
     * @param string $name
     * @return Media
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
     * Set file
     *
     * @param \LightCMS\CoreBundle\Entity\File $file
     * @return Media
     */
    public function setFile(\LightCMS\CoreBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \LightCMS\CoreBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Media
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Media
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set parent
     *
     * @param \LightCMS\MediaBundle\Entity\Media $parent
     * @return Media
     */
    public function setParent(\LightCMS\MediaBundle\Entity\Media $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \LightCMS\MediaBundle\Entity\Media 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \LightCMS\MediaBundle\Entity\Media $children
     * @return Media
     */
    public function addChild(\LightCMS\MediaBundle\Entity\Media $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \LightCMS\MediaBundle\Entity\Media $children
     */
    public function removeChild(\LightCMS\MediaBundle\Entity\Media $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
}
