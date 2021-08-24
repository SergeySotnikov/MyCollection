<?php

namespace App\Utils\Manager;



use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @param User $user
     */

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

    }


    /**
     * @param User $user
     */
    public function remove(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
