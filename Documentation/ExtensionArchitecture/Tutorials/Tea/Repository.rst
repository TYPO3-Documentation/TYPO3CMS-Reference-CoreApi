..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Repository
..  _extbase_tutorial_tea_repositoy:

==========
Repository
==========

A basic repository can be quite a short class. The shortest possible
repository is an empty class inheriting from
:php:`TYPO3\CMS\Extbase\Persistence\Repository`:

..  literalinclude:: _Repository/_BasicRepository.php
    :caption: EXT:tea/Classes/Domain/Repository/Product/TeaRepository.php (simplified)

The model the repository should deliver is derived from the namespace and
name of the repository. A repository with the fully qualified name
:php:`TTN\Tea\Domain\Repository\Product\TeaRepository` therefore delivers
models with the fully qualified name :php:`TTN\Tea\Domain\Model\Product\Tea`
without further configuration.

A special class comment, `@extends Repository<Tea>` tells your IDE and
static analytic tools like PHPStan that the find-by methods of this repository
return objects of type :php-short:`TTN\Tea\Domain\Model\Product\Tea`.

The repository in the tea extension looks like this:

..  literalinclude:: _Repository/_BasicRepository.php
    :caption: EXT:tea/Classes/Domain/Repository/Product/TeaRepository.php

We override the protected parameter :php:`$defaultOrderings` here. This parameter
is also defined in the parent class
:php:`TYPO3\CMS\Extbase\Persistence\Repository` and used here when querying
the database.

Then we also add a custom find-by method. See also chapter
:ref:`"Repository" in the Extbase reference <extbase-repository>`.

..  _extbase_tutorial_tea_repository-usage:

Using the repository
====================

The :php-short:`\TTN\Tea\Domain\Repository\Product\TeaRepository` can now be
used in a controller or another class, for example a service.

Require it via :ref:`Dependency Injection <Dependency-Injection>` in the
constructor:

..  literalinclude:: _Repository/_InjectRepository.php
    :caption: EXT:tea/Classes/Controller/TeaController.php

The method :php:`$this->teaRepository->findAll()` that is called here is
defined in the parent class :php:`\TYPO3\CMS\Extbase\Persistence\Repository`.
