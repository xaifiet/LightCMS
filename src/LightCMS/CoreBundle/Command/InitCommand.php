<?php

namespace LightCMS\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ORM\EntityManager;

use LightCMS\PageBundle\Entity\Site;
use LightCMS\PageBundle\Entity\Page;
use LightCMS\UserBundle\Entity\User;

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

/*        $output->writeln('Creating Login Site');
        $site = new Site();
        $site->setHost('*');
        $site->setPriority(100);
        $site->setTheme('default');
        $site->setTitle('My Site');
        $em->persist($site);

        $em->flush();

        $output->writeln('Creating Home Page');
        $page = new Page();
        $page->setName('Home');
        $page->setUrlname('home');
        $page->setPublished(true);
        $page->setSite($site);
        $em->persist($page);

        $site->setHome($page);
        $em->persist($site);
        $em->flush();*/

/*
        $output->writeln('Creating administrator user');
        $admin = new User();
        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($admin);
        $admin->setPassword($encoder->encodePassword('admin', $admin->getSalt()));
        $admin->setUsername('admin');
        $admin->setFirstname('admin');
        $admin->setLastname('USER');
        $admin->setEmail('admin@localhost');
        $admin->setPlainPassword('admin');
        $admin->setIsPasswordExpired(true);
        $admin->setRole('ROLE_ADMIN');
        $admin->setIsActive(true);
        $em->persist($admin);
        $em->flush();*/

        /*
                $output->writeln('Creating Login Site');
                $folder = new Folder();
                $folder->setName('Login Site');
                $folder->setUrlname('Login Site Root');
                $folder->setPublished(true);
                $folder->setHeader('');
                $em->persist($folder);

                $output->writeln('Creating Home Page');
                $page = new Page();
                $page->setParent($folder);
                $page->setName('Home');
                $page->setUrlname('home');
                $page->setPublished(true);
                $page->setHeader('');
                $page->setBody('This my new Website');
                $page->setFooter('');
                $em->persist($page);



                $em->flush();
        */
        $output->writeln('Done!');
    }
}

?>