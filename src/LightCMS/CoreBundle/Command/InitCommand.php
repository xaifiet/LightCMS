<?php

namespace LightCMS\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use LightCMS\UserBundle\Entity\User;

class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lcms:init')
            ->setDescription('LightCMS database initialisation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $output->writeln('Creating administrator user');
        $admin = new User();
        $admin->setEmail('admin@lcms.com');
        $admin->setFirstname('admin');
        $admin->setLastname('USER');
        $admin->setPlainPassword('admin');
        $admin->setIsPasswordExpired(true);
        $admin->setRole('ROLE_ADMIN');
        $admin->setIsActive(true);
        $em->persist($admin);
        $em->flush();

        $output->writeln('Done!');
    }
}

?>