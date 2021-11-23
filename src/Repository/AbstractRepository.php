<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;


abstract class AbstractRepository
{
    protected EntityManagerInterface $entityManager;
    protected ObjectRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(object $object)
    {
        $this->entityManager->persist($object);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}