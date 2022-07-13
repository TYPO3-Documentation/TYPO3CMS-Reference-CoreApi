
.. index:: Extbase; Application domain

Application domain of the extension
===================================

The domain of the extension is always located below :file:`Classes/Domain`. This folder is structured
as follows:

:file:`Model/`
    Contains the domain models themselves.

:file:`Repository/`
    It contains the repositories to access the domain models.

:file:`Validator/`
    Contains specific validators for the domain models.


.. index:: Extbase; Domain models

Domain model
------------

All classes of the domain model must inherit from one of the following two classes:

:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`
    It is used if the object is an entity, i.e., possesses an identity.

:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject`
    Is used if the object is a ValueObject, i.e. if its identity is defined by all of its properties.
    ValueObjects are immutable.

:php:`TYPO3\CMS\Core\Type\TypeInterface`
   Is used if the object is stored as a single value.
   The class has to implement :php:`__toString()` to return the value for storage.
   The class receives the stored value as first argument in :php:`__construct()`.

   A small example:

   .. code-block:: php
      :caption: EXT:my_extension/Classes/Domain/Model/ModelName.php

       <?php

       namespace Vendor\MyExtension\Domain\Model;

       use TYPO3\CMS\Core\Type\TypeInterface;

       final class ModelName implements TypeInterface
       {
           private array $data = [];

           public function __construct(string $serialized)
           {
               $this->data = json_decode(
                   $serialized,
                   true,
                   JSON_THROW_ON_ERROR
               );
           }

           // Add getter/setters to update internal data

           public function __toString(): string
           {
               return json_encode($this->data);
           }
       }

   That way it is not necessary to have proper database columns.
   This is helpful for serialized data and rapid prototyping.


.. index:: Extbase; Repositories

Repositories
------------

All repositories inherit from :php:`\TYPO3\CMS\Extbase\Persistence\Repository`. A repository is always
responsible for precisely one type of domain object. The naming of the repositories is important:
If the domain object is, for example, *Blog* (with full name `\\Ex\\BlogExample\\Domain\\Model\\Blog`),
then the corresponding repository is named *BlogRepository* (with the full name
`\\Ex\\BlogExample\\Domain\\Repository\\BlogRepository`).

