<?php

namespace LightCMS\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ORM\EntityManager;

use LightCMS\CoreBundle\Entity\Page;
use LightCMS\CoreBundle\Entity\Gallery;

class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lcms:init')
            ->setDescription('LightCMS database initialisation')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $output->writeln('Creating Home Page');

        $page = new \LightCMS\PageBundle\Entity\Page();
        $page->setName('Home');
        $page->setUrlname('home');
        $page->setPublished(true);
        $page->setHeader('');
        $page->setBody('This my new Website');
        $page->setFooter('');
        $em->persist($page);

        $output->writeln('Creating Default Site');
        $site = new \LightCMS\CoreBundle\Entity\Site();
        $site->setTitle('My Site');
        $site->setLayout('default');
        $site->setHost('*');
        $site->setPriority(100);
        $site->setNode($page);
        $em->persist($site);

        $em->flush();

        $output->writeln('Done!');
    }
}

?>