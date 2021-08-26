<?php


namespace App\EventSubscriber;



use App\Event\UserLoginViaSocialNetworkEvent;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserLoginViaSocialNeetwork  implements EventSubscriberInterface
{
    public function onUserLoginViaSocialNetworkEvent(UserLoginViaSocialNetworkEvent $event)
    {
        $user = $event->getUser();
        $plainPassword = $event->getPainPassword();

    }

    #[ArrayShape([UserLoginViaSocialNetworkEvent::class => "string"])] public static function getSubscribedEvents(): array
    {
        return [
            UserLoginViaSocialNetworkEvent::class=>'onUserLoginViaSocialNetworkEvent'
        ];
    }
}