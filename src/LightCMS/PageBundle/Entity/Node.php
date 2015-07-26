<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_nodes")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Node
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @ORM\GeneratedValue(strategy="NONE")
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="children")
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent", cascade={"all"})
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
        $this->id = md5(uniqid(null, true));
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->updated = new \DateTime();
        if (is_null($this->created)) {
            $this->created = $this->updated;
        }
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Node
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
     * Set name
     *
     * @param string $name
     * @return Node
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
     * Set created
     *
     * @param \DateTime $created
     * @return Node
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
     * @return Node
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
     * @param \LightCMS\PageBundle\Entity\Node $parent
     * @return Node
     */
    public function setParent(\LightCMS\PageBundle\Entity\Node $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \LightCMS\PageBundle\Entity\Node 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \LightCMS\PageBundle\Entity\Node $children
     * @return Node
     */
    public function addChild(\LightCMS\PageBundle\Entity\Node $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \LightCMS\PageBundle\Entity\Node $children
     */
    public function removeChild(\LightCMS\PageBundle\Entity\Node $children)
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
