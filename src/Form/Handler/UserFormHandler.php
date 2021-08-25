<?php

namespace App\Form\Handler;

use App\Entity\User;
use App\Utils\Manager\UserManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFormHandler
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserManager $userManager;

    public function __construct(UserManager $userManager, UserPasswordEncoderInterface $passwordEncoder)
        {

            $this->passwordEncoder = $passwordEncoder;
            $this->userManager = $userManager;
        }


        public function processEditForm (Form $form)
        {
            //смена пороля
            $plainPassword = $form->get('plainPassword')->getData();
            $newEmail = $form->get('newEmail')->getData();

            /** @var User $user */
            $user = $form->getData();

            if (!$user->getId())
            {
                $user->setEmail($newEmail);
            }


            if ($plainPassword)
            {
                $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
            }

            $this->userManager->save($user);

            return $user;


        }

}