<?php

namespace LightCMS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_pages")
 */
class Page
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Choice(choices = {"media", "content"}, message = "node.validation.type")
     **/
    private $type;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $urlTitle;

    /**
     * @ORM\Column(type="text")
     **/
    private $head;

    /**
     * @ORM\Column(type="text")
     **/
    private $body;

    /**
     * @ORM\Column(type="text")
     **/
    private $foot;

    /**
     * @ORM\Column(type="boolean")
     **/
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     * @Assert\Valid
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent", cascade={"all"})
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
     * @return void
     */
    public function __construct() {
        $this->children = new ArrayCollection();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
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
     * Set type
     *
     * @param string $type
     * @return Page
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set urlTitle
     *
     * @param string $urlTitle
     * @return Page
     */
    public function setUrlTitle($urlTitle)
    {
        $this->urlTitle = $urlTitle;

        return $this;
    }

    /**
     * Get urlTitle
     *
     * @return string 
     */
    public function getUrlTitle()
    {
        return $this->urlTitle;
    }

    /**
     * Set head
     *
     * @param string $head
     * @return Page
     */
    public function setHead($head)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get head
     *
     * @return string 
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Page
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set foot
     *
     * @param string $foot
     * @return Page
     */
    public function setFoot($foot)
    {
        $this->foot = $foot;

        return $this;
    }

    /**
     * Get foot
     *
     * @return string 
     */
    public function getFoot()
    {
        return $this->foot;
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
     * Set created
     *
     * @param \DateTime $created
     * @return Page
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
     * @return Page
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
     * @param \LightCMS\CoreBundle\Entity\Page $parent
     * @return Page
     */
    public function setParent(\LightCMS\CoreBundle\Entity\Page $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \LightCMS\CoreBundle\Entity\Page 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \LightCMS\CoreBundle\Entity\Page $children
     * @return Page
     */
    public function addChild(\LightCMS\CoreBundle\Entity\Page $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \LightCMS\CoreBundle\Entity\Page $children
     */
    public function removeChild(\LightCMS\CoreBundle\Entity\Page $children)
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
