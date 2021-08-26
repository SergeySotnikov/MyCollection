<?php

namespace App\Utils\Manager;



use App\Entity\User;
use App\Exception\Security\EmptyUserPlainPasswordException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{

    private EntityManagerInterface $entityManager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager , UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     * @param string $plainPassword
     */

    public function encodePassword(User $user, string $plainPassword): void
    {
        $newPassword = trim($plainPassword);
        if (!$newPassword) {
            throw new EmptyUserPlainPasswordException('Empty user\'s password ');
        }

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $newPassword)
        );

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

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

    }


    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
