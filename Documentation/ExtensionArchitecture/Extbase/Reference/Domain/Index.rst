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

For a deeper understanding, see:
https://en.wikipedia.org/wiki/Domain-driven_design

The :path:`Classes/Domain/` folder contains all the domain logic of your Extbase
extension. This is where you model the real-world concepts of your application
and define how they behave.

While Domain-Driven Design (DDD) suggests putting business-related services in
the Domain layer, in most TYPO3 extensions, you will actually see service
classes placed in: :path:`Classes/Service/`. It is also possible to put them
into :path:`Classes/Domain/Service/`.

..  contents:: Table of contents

..  toctree::
    :titlesonly:
    :glob:
    :hidden:

    */Index

..  _extbase-domain-example:

Basic example of a model with a repository in Extbase
=====================================================

The following example shows a basic model (representing a scientific paper in
real life) and its corresponding repository.

..  tabs::

    ..  tab:: Model

        ..  literalinclude:: _codesnippets/_Paper.php
            :caption: packages/my_extension/Classes/Domain/Model/Paper.php

        All properties that will be persisted must be declared as `protected`
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

        The PHPDoc `@extends Repository<Paper>` annotation helps static analysis
        tools (like PHPStan or Psalm) and IDEs for better type inference and
        autocompletion.

    ..  tab:: TCA / Database table

        By default a model is persisted to a database table of the following
        naming scheme: `tx_[extension]_domain_model_[model].php`. To create
        and define the database table use a TCA configuration:

        ..  literalinclude:: _codesnippets/_paper_tca.php
            :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_paper.php

..  _extbase-domain-subfolders:

Subfolders of `Classes/Domain/`
===============================

Typical subfolders include:

.. card-grid::
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

        Holds custom validators for domain objects. Use these to enforce
        business rules and validate object states.
