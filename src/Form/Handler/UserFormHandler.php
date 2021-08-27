<?php

namespace App\Form\Handler;

use App\Entity\User;
use App\Utils\Manager\UserManager;
use ContainerQumZ55C\PaginatorInterface_82dac15;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFormHandler
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserManager $userManager;
    private PaginatorInterface $paginator;

    public function __construct(UserManager $userManager, UserPasswordEncoderInterface $passwordEncoder, PaginatorInterface $paginator)
        {

            $this->passwordEncoder = $passwordEncoder;
            $this->userManager = $userManager;
            $this->paginator = $paginator;
        }

        public function processUserFiltersForm($request, $filterForm)
        {
            $queryBuilder= $this->userManager->getRepository()
            ->createQueryBuilder('o');

            return $this->paginator->paginate(
                $queryBuilder->getQuery(),
                $request->query->getInt('page',1)
            );

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