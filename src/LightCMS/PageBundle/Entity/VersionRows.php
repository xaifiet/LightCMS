<?php

namespace LightCMS\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lcms_versions_rows")
 */
class VersionRows extends \LightCMS\PageBundle\Entity\Version
{

    /**
     * @ORM\OneToMany(targetEntity="Version", mappedBy="page", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"number" = "ASC"})
     **/
    private $versions;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->versions = new ArrayCollection();
    }

    public function getInheritanceType()
    {
        return 'pagerows';
    }


    /**
     * Add versions
     *
     * @param \LightCMS\PageBundle\Entity\Version $versions
     * @return Page
     */
    public function addVersion(\LightCMS\PageBundle\Entity\Version $versions)
    {
        $this->versions[] = $versions;

        return $this;
    }

    /**
     * Remove versions
     *
     * @param \LightCMS\PageBundle\Entity\Version $versions
     */
    public function removeVersion(\LightCMS\PageBundle\Entity\Version $versions)
    {
        $this->versions->removeElement($versions);
    }

    /**
     * Get versions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVersions()
    {
        return $this->versions;
    }
}
