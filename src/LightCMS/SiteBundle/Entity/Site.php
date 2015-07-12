<?php

namespace LightCMS\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_sites")
 */
class Site
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $host;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $layout;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="\LightCMS\NodeBundle\Entity\Node")
     * @ORM\JoinColumn(referencedColumnName="salt")
     **/
    private $rootNode;

    /**
     * @ORM\ManyToOne(targetEntity="\LightCMS\NodeBundle\Entity\Node")
     * @ORM\JoinColumn(referencedColumnName="salt")
     **/
    private $homeNode;

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
     * Set host
     *
     * @param string $host
     * @return Site
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Site
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set layout
     *
     * @param string $layout
     * @return Site
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return string 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Site
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
     * Set created
     *
     * @param \DateTime $created
     * @return Site
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
     * @return Site
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
     * Set rootNode
     *
     * @param \LightCMS\NodeBundle\Entity\Node $rootNode
     * @return Site
     */
    public function setRootNode(\LightCMS\NodeBundle\Entity\Node $rootNode = null)
    {
        $this->rootNode = $rootNode;

        return $this;
    }

    /**
     * Get rootNode
     *
     * @return \LightCMS\CoreBundle\Entity\Node 
     */
    public function getRootNode()
    {
        return $this->rootNode;
    }

    /**
     * Set homeNode
     *
     * @param \LightCMS\NodeBundle\Entity\Node $homeNode
     * @return Site
     */
    public function setHomeNode(\LightCMS\NodeBundle\Entity\Node $homeNode = null)
    {
        $this->homeNode = $homeNode;

        return $this;
    }

    /**
     * Get homeNode
     *
     * @return \LightCMS\CoreBundle\Entity\Node 
     */
    public function getHomeNode()
    {
        return $this->homeNode;
    }
}
