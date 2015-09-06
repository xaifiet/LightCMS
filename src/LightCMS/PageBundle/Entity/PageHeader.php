<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_pages_header")
 */
class PageHeader extends Page
{

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getInheritanceType()
    {
        return 'pagecontent';
    }


    /**
     * Set Content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

}
