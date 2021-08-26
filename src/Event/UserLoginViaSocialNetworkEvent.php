<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserLoginViaSocialNetworkEvent extends Event
{


    private User $user;
    private string $plainPassword;

    public function __construct(User $user, string $plainPassword)
    {

        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }


    /**
     * @return User
     */

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPainPassword(): string
    {
        return $this->plainPassword;
    }
}