<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_sites")
 */
class Site extends \LightCMS\CoreBundle\Entity\Node
{

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
     * @ORM\OneToOne(targetEntity="Page", cascade={"all"})
     * @ORM\JoinColumn(nullable=true)
     **/
    private $home;

    public function getInheritanceType()
    {
        return 'site';
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
     * Set home
     *
     * @param \LightCMS\PageBundle\Entity\Page $home
     * @return Site
     */
    public function setHome(\LightCMS\PageBundle\Entity\Page $home = null)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home
     *
     * @return \LightCMS\PageBundle\Entity\Page 
     */
    public function getHome()
    {
        return $this->home;
    }
}
