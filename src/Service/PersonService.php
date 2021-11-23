<?php

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Exception\RuntimeException;

class PersonService
{
    public function __construct(
        private PersonRepository $personRepository,
        private PassportCloudService $passportCloudService,
    )
    {
    }

    /**
     * @param $url
     * @return Person[]
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function parsePersonsFromGoogleTable($url): array
    {
        if (!$id = explode('/', $url)[5] ?? null) {
            throw new RuntimeException('Can not get id from url: ' . $url);
        }
        $gid = 0;
        $csvExportUrl = "https://docs.google.com/spreadsheets/d/{$id}/export?format=csv&gid={$gid}";
        $fh = fopen($csvExportUrl, "r");
        fgetcsv($fh, 0, ',');

        /** @var Person[] $persons */
        $persons = [];
        while (($row = fgetcsv($fh, 0, ',')) !== false) {
            list(
                $passportId,
                $passportDateOfIssue,
                $passportDateOfBirth,
                $passportEndDate,
                $name,
                $surname,
                $generatedValue
            ) = $row;

            $person = new Person(
                $passportId,
                DateTime::createFromFormat('d.m.Y', $passportDateOfIssue),
                DateTime::createFromFormat('d.m.Y', $passportDateOfBirth),
                DateTime::createFromFormat('d.m.Y', $passportEndDate),
                $name,
                $surname,
                $generatedValue ?: null
            );

            $this->personRepository->persist($person);

            $persons[] = $person;
        }

        $this->personRepository->flush();
        return $persons;
    }

    public function fillGeneratedValues()
    {
        $persons = $this->personRepository->getPersonsWithoutGeneratedValue();
        foreach ($persons as $person) {
            $person = $this->passportCloudService->fillGeneratedValue($person);
            $this->personRepository->persist($person);
        }
        $this->personRepository->flush();
    }
}