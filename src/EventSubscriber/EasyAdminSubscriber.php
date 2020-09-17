<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeCrudActionEvent::class => ['setUpdatedTimeRole'],
        ];
    }

    public function setUpdatedTimeRole(BeforeCrudActionEvent $event)
    {
        $entity = $event->getAdminContext()->getEntity()->getInstance();

        $entity->setUpdatedAt(new \DateTime());
    }
}