<?php

namespace LightCMS\UserBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\DependencyInjection\ContainerInterface;

use LightCMS\USerBundle\Entity\User;

class UserEventListener
{

    protected $container;

    protected $encoderFactory;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->encoderFactory = $container->get('security.encoder_factory');
    }

    public function getEncoder(User $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }

    public function updateUser(User $user)
    {
        $plainPassword = $user->getPlainPassword();

        if (!empty($plainPassword)) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($plainPassword, $user->getSalt()));
            $user->eraseCredentials();
        }
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $user = $event->getEntity();

        if (!($user instanceof User)) {
            return;
        }

        $this->updateUser($user);
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $user = $event->getEntity();

        if (!($user instanceof User)) {
            return;
        }

        $this->updateUser($user);
    }

}