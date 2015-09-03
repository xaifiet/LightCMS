<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_widget_content")
 */
class WidgetContent extends Widget
{

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function __construct()
    {
        parent::__construct();
        $this->content = '';
    }


    /**
     * Set content
     *
     * @param string $content
     * @return WidgetContent
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
