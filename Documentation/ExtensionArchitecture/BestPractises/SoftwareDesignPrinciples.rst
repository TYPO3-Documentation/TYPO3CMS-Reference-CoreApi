:navigation-title: Software design

..  include:: /Includes.rst.txt
..  index:: Extension development; Software Design Principles
..  _extension-software-design-principles:

==========================
Software design principles
==========================

The following principles are considered best practices and are good to know when you develop
extensions for TYPO3.

*   `Object-Oriented Programming (OOP) <https://phptherightway.com/#programming_paradigms>`__
    organizes software design around data, or objects, rather than the functions and logic of procedural programming.
*   `Domain-Driven Design (DDD) <https://leanpub.com/ddd-in-php>`__ is a
    collection of principles and patterns that help developers design elegant
    code around clearly defined conceptual models.
*   `Model-View-Controller (MVC) <https://code.tutsplus.com/tutorials/mvc-for-noobs--net-10488>`__
    is a programming paradigm that leads to clear isolation of data,
    presentation layer, and business logic.
*   `Test-Driven Development (TDD) <https://phptherightway.com/#test_driven_development>`__
    is a basic technique for generating code that is stable,
    resilient to errors, and legible — and therefore maintainable.
*   `Dependency Injection <https://phptherightway.com/#dependency_injection>`__
    is a software design pattern that adds flexibility by removing the need
    for hard-coded dependencies.
*   `Separation of Concerns <https://en.wikipedia.org/wiki/Separation_of_concerns>`__
    and `Single-responsibility principle (SRP) <https://en.wikipedia.org/wiki/Single-responsibility_principle>`__
    are computer programming principles that help developers create modular,
    coherent, and maintainable software.

We also recommend to study common `software design
patterns <https://designpatternsphp.readthedocs.io/en/latest/>`__.

..  _concept-dto:

Data Transfer Objects (DTO) as a software design concept
========================================================

A very common pattern in Extbase extensions is a :abbr:`DTO (Data Transfer Object)`.

A DTO is an instance of a basic class that usually only has a constructor,
getters and setters. It is not meant to be an extension of an Extbase `AbstractEntity`.

This DTO serves as pure data storage. You can use it to receive and retrieve
data in a `<f:form>` Fluid
`CRUD <https://en.wikipedia.org/wiki/Create,_read,_update_and_delete>`__
("Create Read Update Delete") setup.

Later on, the DTO can be accessed and converted into a "proper" Extbase domain model
entity: The DTO getters retrieve the data, and the Extbase domain model entity's setters
receive that data:

..  literalinclude:: _dto.php
    :language: php
    :caption: Example of DTO and AbstractEntity used in an Extbase controller

DTOs are helpful because:

*   They allow to decouple pure data from processed/validated data in entities.
*   They allow to structure data into distinct data models.
*   They allow to use good type hinting and using setters/getters instead of using
    untyped and unstructured PHP arrays for data storage.
*   They can be used to hide implementation details of your actual entities by transferring
    data like filter settings that internally gets applied to actual data models.


..  seealso::

    *   `Extbase reference: Data transfer objects (DTO) in Extbase <https://usetypo3.com/dtos-in-extbase/>`_
    *   `usetypo3.com: Data Transfer Objects in Extbase <https://usetypo3.com/dtos-in-extbase/>`_
