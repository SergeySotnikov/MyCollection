<?php

namespace App\Utils\Manager;


use App\Entity\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class CollectionManager
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
        return $this->entityManager->getRepository(Collection::class);
    }

    /**
     * @param Collection $collection
     */

    public function save(Collection $collection)
    {
        $this->entityManager->persist($collection);
        $this->entityManager->flush();

    }


    /**
     * @param Collection $collection
     */
    public function remove(Collection $collection)
    {
        $this->entityManager->remove($collection);
        $this->entityManager->flush();
    }
}
