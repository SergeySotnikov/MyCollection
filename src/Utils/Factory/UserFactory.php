<?php

namespace App\Utils\Factory;

use App\Entity\User;
use League\OAuth2\Client\Provider\FacebookUser;

class UserFactory

{
    /**
     * @param FacebookUser $facebookUser
     * @return User
     */

    public static function createUserFromFacebookUser(FacebookUser $facebookUser): User
    {
        $user = new User();
        $user->setEmail($facebookUser->getEmail());
        $user->setFullName($facebookUser->getName());
        $user->setFacebookId($facebookUser->getId());

        return $user;

    }
}