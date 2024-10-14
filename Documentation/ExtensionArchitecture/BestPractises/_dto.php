<?php

declare(strict_types=1);

// The actual "plain" DTO, just setters and getters
class PersonDTO
{
    protected string $first_name;
    protected string $last_name;

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }
}

// The Extbase domain model entity.
// Note that the getters and setters can easily be mapped
// to the DTO due to their same names!
class Person extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $first_name;
    protected string $last_name;

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }
}

// An Extbase controller utilizing DTO-to-entity transfer
class DtoController extends TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    public function __construct(protected MyVendor\MyExtension\Domain\Repository\PersonRepository $personRepository)
    {
    }

    function createAction(): Psr\Http\Message\ResponseInterface
    {
        // Set up a DTO to be filled with input data.
        // The Fluid template would use <f:form> and its helpers.
        $this->view->assign('personDTO', new PersonDTO());
    }

    function saveAction(PersonDTO $personDTO): Psr\Http\Message\ResponseInterface
    {
        // Transfer all data to a proper Extbase entity.
        // Create an empty entity first:
        $person = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Person::class);

        // Use setters/getters for propagation
        $person->setFirstName($personDTO->getFirstName());
        $person->setLastName($personDTO->getLastName());

        // Persist the extbase entity
        $this->personRepository->add($person);

        // The "old" DTO needs to further processing.
    }
}
