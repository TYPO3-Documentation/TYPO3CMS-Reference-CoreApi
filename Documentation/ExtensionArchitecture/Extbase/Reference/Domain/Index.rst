:navigation-title: Domain

..  include:: /Includes.rst.txt
..  index:: Extbase; Domain
..  _extbase-domain:

=========================
Domain concept in Extbase
=========================

The domain layer is where you define the core logic and structure of your
application — things like entities, value objects, repositories, and
validators.

See https://en.wikipedia.org/wiki/Domain-driven_design for more in-depth
information.

The :path:`Classes/Domain/` folder contains the domain logic of your Extbase
extension. This is where you model real-world concepts in your application
and define how they behave.

The Domain Model Object in the :path:`Classes/Domain/Model/` folder defines which 
table fields are available for a database table. These must correspond to the fields in
the TCA. 

Queries in `Extbase repositories  <https://docs.typo3.org/permalink/t3coreapi:extbase-repository>`_
made with the Extbase (:php:`\TYPO3\CMS\Extbase\Persistence\QueryInterface`) are limited to 
the fields defined in the model, while `DBAL <https://docs.typo3.org/permalink/t3coreapi:doctrine-dbal>`_
queries based on the `Query builder  <https://docs.typo3.org/permalink/t3coreapi:database-query-builder>`_
are only limited to fields defined in the TCA.

An Extbase model is a subset of the fields contained in the 
`Record object  <https://docs.typo3.org/permalink/t3coreapi:record-objects>`_ of the connected table.

While Domain-Driven Design (DDD) suggests putting business-related services in
the Domain layer, in most TYPO3 extensions you will actually see service
classes placed in: :path:`Classes/Service/`. It is also possible to put them
in :path:`Classes/Domain/Service/`.

..  contents:: Table of contents

..  toctree::
    :titlesonly:
    :glob:
    :hidden:

    */Index

..  _extbase-domain-example:

Basic example of a model with a repository in Extbase
=====================================================

This example shows a basic model (representing a scientific paper in
real life) and its corresponding repository.

..  tabs::

    ..  tab:: Model

        ..  literalinclude:: _codesnippets/_Paper.php
            :caption: packages/my_extension/Classes/Domain/Model/Paper.php

        Properties that will be persisted must be declared as `protected`
        or `public`.

        To make properties available in Fluid templates, you must provide
        either a `public` property or a `public` getter method (starting with
        `get`, `has`, or `is`).

    ..  tab:: Repository

        This repository follows Extbase's naming conventions and may stay empty
        unless custom queries are needed.

        ..  literalinclude:: _codesnippets/_PaperRepository.php
            :caption: packages/my_extension/Classes/Domain/Repository/PaperRepository.php

        Extbase automatically detects which model the repository belongs to
        based on the naming convention `<ModelName>Repository`. No registration
        is necessary.

        The PHPDoc `@extends Repository<Paper>` annotation helps static
        analysis tools (like PHPStan or Psalm) and IDEs with type inference and
        autocompletion.

    ..  tab:: TCA / Database table

        By default a model is persisted to a database table with the following
        naming scheme: `tx_[extension]_domain_model_[model].php`. To create
        and define the database table use TCA configuration:

        ..  literalinclude:: _codesnippets/_paper_tca.php
            :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_paper.php

..  _extbase-domain-subfolders:

Subfolders of `Classes/Domain/`
===============================

Typical subfolders include:

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    .. card:: `Model <https://docs.typo3.org/permalink/t3coreapi:extbase-model>`_

        Contains domain entities, value objects, DTOs, and enums. These define
        your application's core data structures and behaviors.

    .. card:: `Repository <https://docs.typo3.org/permalink/t3coreapi:extbase-repository>`_

        Repositories provide methods for retrieving and saving domain objects.
        They abstract persistence logic from the rest of the application.

    .. card:: `Validator <https://docs.typo3.org/permalink/t3coreapi:extbase-domain-validator>`_

        Provides custom validators for domain objects. Use these to enforce
        business rules and validate object states.
