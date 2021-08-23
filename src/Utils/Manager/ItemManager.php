<?php

namespace App\Utils\Manager;


use App\Entity\CollectionItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ItemManager
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
        return $this->entityManager->getRepository(CollectionItem::class);
    }

    /**
     * @param CollectionItem $collectionItem
     */

    public function save(CollectionItem $collectionItem)
    {
        $this->entityManager->persist($collectionItem);
        $this->entityManager->flush();

    }


    /**
     * @param CollectionItem $collectionItem
     */
    public function remove(CollectionItem $collectionItem)
    {
        $this->entityManager->remove($collectionItem);
        $this->entityManager->flush();
    }
}
