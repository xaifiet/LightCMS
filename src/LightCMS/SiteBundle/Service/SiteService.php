<?php

namespace LightCMS\SiteBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SiteService
 *
 * @package LightCMS\SiteBundle\Service
 */
class SiteService
{

    /**
     * request
     *
     * @var mixed
     * @access private
     */
    private $request;

    /**
     * entityManager
     *
     * @var mixed
     * @access private
     */
    private $entityManager;

    /**
     * siteRepository
     *
     * @var mixed
     * @access private
     */
    private $siteRepository;

    /**
     * site
     *
     * @var \LightCMS\CoreBundle\Entity\Site
     * @access private
     */
    private $site;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $container
     */
    public function __construct($container)
    {
        // Getting the request from container
        $this->request = $container->get('request');

        // Getting the Entity Manager from container
        $this->entityManager = $container->get('doctrine.orm.entity_manager');

        // Getting the Site Repository from Entity Manager
        $this->siteRepository = $this->entityManager->getRepository('LightCMSSiteBundle:Site');

        // Fetching the current site
        $this->fetchCurrentSite();
    }

    /**
     * getSite function.
     *
     * Getting current site from HTTP Request
     *
     * @access public
     * @return LightCMS\CoreBundle\Entity\Site
     */
    private function fetchCurrentSite()
    {
        // Getting all available sites by priority
        $sites = $this->siteRepository->findBy(array(), array('priority' => 'ASC'));

        // Loop on sites
        foreach ($sites as $site) {

            // Preparing regexp for matching
            $regexp = '/'.str_replace('*', '.+', $site->getHost()).'/';

            // Check the regexp and return Site if matching
            if (preg_match($regexp, $this->request->getHost())) {
                $this->site = $site;
                return true;
            }
        }

        // Throwing exception if no site available
        throw new NotFoundHttpException('No available Site for this request !');
    }

    /**
     * @return \LightCMS\CoreBundle\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * getHome function.
     *
     * Searching the home page from asked request site
     *
     * @access public
     * @return LightCMS\CoreBundle\Entity\Page
     */
    public function getHome()
    {
        // Getting home page from site
        $node = $this->site->getNode();

        // Returning the page if not null
        if (!is_null($node)) {
            return $node;
        }

        // Throwing an exception if no home page available
        throw new NotFoundHttpException('No home page for this site !');
    }

    /**
     *
     */
    public function getLayoutTemplate()
    {
        return 'LightCMSCoreBundle:Layout/'.$this->site->getLayout().':layout.html.twig';
    }

}

?>