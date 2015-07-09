<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_pages")
 */
class Page extends \LightCMS\CoreBundle\Entity\Node
{

    /**
     * @ORM\Column(type="text")
     */
    private $header;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="text")
     */
    private $footer;

    /**
     * Set header
     *
     * @param string $header
     * @return Page
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
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
     * Set footer
     *
     * @param string $footer
     * @return Page
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }
}
