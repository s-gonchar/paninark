<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class PersonRepository extends AbstractRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repo = $entityManager->getRepository(Person::class);
    }

    /**
     * @return Person[]
     */
    public function getPersonsWithoutGeneratedValue(): array
    {
        return $this->repo->findBy(['generatedValue' => null]);
    }
}