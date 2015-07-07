<?php

namespace LightCMS\CoreBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SiteService
{

    /**
     * container
     *
     * @var mixed
     * @access private
     */
    private $container;

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
     * __construct function.
     *
     * @access public
     * @param mixed $container
     * @return void
     */
    public function __construct($container)
    {
        // Getting the request from container
        $this->request = $container->get('request');

        // Getting the Entity Manager from container
        $this->entityManager = $container->get('doctrine.orm.entity_manager');

        // Getting the Site Repository from Entity Manager
        $this->siteRepository = $this->entityManager->getRepository('LightCMSCoreBundle:Site');
    }

    /**
     * getSite function.
     *
     * Getting current site from HTTP Request
     *
     * @access public
     * @return LightCMS\CoreBundle\Entity\Site
     */
    public function getSite()
    {
        // Getting all available sites by priority
        $sites = $this->siteRepository->findBy(array(), array('priority' => 'ASC'));

        // Loop on sites
        foreach ($sites as $site) {
            // Preparing regexp for matching
            $regexp = '/'.str_replace('*', '.+', $site->getHost()).'/';
            // Check the regexp and return Site if matching
            if (preg_match($regexp, $this->request->getHost())) {
               return $site;
            }
        }

        // Throwing exception if no site available
        throw new NotFoundHttpException('No available Site for this request !');
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
        // Getting site
        $site = $this->getSite();

        // Getting home page from site
        $page = $site->getHome();

        // Returning the page if not null
        if (!is_null($page)) {
            return $page;

        }

        // Throwing an exception if no home page available
        throw new NotFoundHttpException('No home page for this site !');
    }

}

?>