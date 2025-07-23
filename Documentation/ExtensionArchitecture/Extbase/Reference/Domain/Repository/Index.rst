:navigation-title: Repository

..  include:: /Includes.rst.txt
..  index:: Extbase; Repositories
..  _extbase-repository:

==================
Extbase repository
==================

All :ref:`Extbase <extbase>` repositories inherit from
:php:`\TYPO3\CMS\Extbase\Persistence\Repository`.

A repository is always responsible for precisely one type of
:ref:`domain object (model) <extbase-model>`.

The naming of the repositories is important:
If the domain object is, for example, *Blog* (with full name
:php:`\FriendsOfTYPO3\BlogExample\Domain\Model\Blog`),
then the corresponding repository is named *BlogRepository* (with the full name
:php:`\FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository`).

The :php:`\TYPO3\CMS\Extbase\Persistence\Repository` already offers a large
number of useful functions. Therefore, in simple classes that extend the
:php:`Repository` class and leaving the class empty otherwise is sufficient.

The :php:`BlogRepository` sets some default orderings and is otherwise empty:

..  include:: /CodeSnippets/Extbase/Domain/BlogRepository.rst.txt

..  contents:: **Table of contents**
    :local:

..  seealso::
    If you are using the :composer:`stefanfroemken/ext-kickstarter` you can use
    command `vendor/bin/typo3 make:repository` to generate an Extbase repository.

    Make sure, you create the `Model <https://docs.typo3.org/permalink/t3coreapi:extbase-model>`_
    first.

..  _extbase-repository-find-methods:

Find methods
============

..  versionadded:: 12.3

    The (not-magic) methods `findByUid()` and `findByIdentifier()` have **not**
    been deprecated or removed, and are still valid.

    Using these methods will fetch a given domain object by it's UID, ignoring possible storage
    page settings - unlike `findBy([...])`, which does respect those settings.

The :php:`Repository` class provides the following methods for querying against
arbitrary criteria:

:php:`findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): QueryResultInterface`
   Finds all objects with the provided criteria.

:php:`findOneBy(array $criteria, array $orderBy = null): object|null`
   Returns the first object found with the provided criteria.

:php:`count(array $criteria): int`
   Counts all objects with the provided criteria.

Example:

..  code-block:: php

    $this->blogRepository->findBy(['author' => 1, 'published' => true]);

..  attention::
    Saving a :php:`QueryResult` to a cache is not possible, if objects in the 
    :php:`QueryResult` contain closures. This is typically the case for models
    which use lazy loading on properties.

..  _extbase-repository-find-by-custom:

Custom find methods
===================

Custom find methods can be implemented. They can be used for complex queries.

..  attention::
    As Extbase repositories turn the results into objects, querying large
    amounts of data is resource-intensive.

**Example:**

The :php:`PostRepository` of the :composer:`t3docs/blog-example` example extension implements
several custom find methods, two of them are shown below:

..  include:: /CodeSnippets/Extbase/Domain/CustomMethods.rst.txt

..  _extbase-repository-find-by-magic:

Magic find methods
==================

..  deprecated:: 12.3
    As these methods are widely used in almost all Extbase-based extensions,
    they are marked as deprecated in TYPO3 v12, but will only trigger a
    deprecation notice in TYPO3 v13, as they will be removed in TYPO3 v14.
    Migrate the usage of these methods to the new
    :ref:`find methods <extbase-repository-find-methods>`.

The :php:`Repository` class creates "magic" methods to find by attributes of
model.

:php:`findBy[PropertyName]`
   Finds all objects with the provided property.

:php:`findOneBy[PropertyName]`
   Returns the first object found with the provided property.

:php:`countBy[PropertyName]`
   Counts all objects with the provided property.

If necessary, these methods can also be overridden by implementing them in the
concrete repository.

..  _extbase-repository-find-by-magic-migration:

Migration
---------

:php:`findBy[PropertyName]($propertyValue)` can be replaced with a call to
:php:`findBy()`:

..  code-block:: php

    $this->myRepository->findBy(['propertyName' => $propertyValue]);

:php:`findOneBy[PropertyName]($propertyValue)` can be replaced with a call to
:php:`findOneBy`:

..  code-block:: php

    $this->myRepository->findOneBy(['propertyName' => $propertyValue]);

:php:`countBy[PropertyName]($propertyValue)` can be replaced with a call to
:php:`count`:

..  code-block:: php

    $this->myRepository->count(['propertyName' => $propertyValue]);

..  _extbase-repository-query-setting:

Query settings
===============

If the query settings should be used for all methods in the repository,
they should be set in the method :php:`initializeObject()` method.

..  include:: /CodeSnippets/Extbase/Domain/DefaultQuerySettings.rst.txt

..  attention::
    Depending on the query settings, hidden or even deleted objects can become
    visible. This might cause sensitive information to be disclosed. Use with care.

If you only want to change the query settings for a specific method, they can be
set in the method itself:

..  include:: /CodeSnippets/Extbase/Domain/SpecialQuerySettings.rst.txt

..  _extbase-repository-api:

Repository API
===============

..  include:: /CodeSnippets/Extbase/Api/Repository.rst.txt


..  _extbase-repository-localization:

Typo3QuerySettings and localization
===================================

Extbase renders the translated records in the same way as TypoScript rendering.

..  versionchanged:: 12.0
    The Extbase query settings rely on
    :php:`\TYPO3\CMS\Core\Context\LanguageAspect` now.

The following methods can be used to set and get the :ref:`language aspect <context_api_aspects_language>`  from any
:php:`\TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface`:

-   :php:`QuerySettingsInterface::getLanguageAspect(): LanguageAspect`
-   :php:`QuerySettingsInterface::setLanguageAspect(LanguageAspect $aspect)`

You can specify a custom language aspect per query as defined in the query settings
in any repository class:

Example to use the fallback to the default language when working with overlays:

..  literalinclude:: _codesnippets/_LanguageAspect.php
    :language: php
    :caption: EXT:my_extension/Classes/Repository/MyRepository.php

..  _extbase-repository-debug-query:

Debugging an Extbase query
==========================

When using complex queries in Extbase repositories it sometimes comes handy
to debug them using the Extbase debug utilities.

..  literalinclude:: _codesnippets/_DebugQuery.php
    :language: php
    :caption: EXT:my_extension/Classes/Repository/MyRepository.php

Please note that :php:`\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser`
is marked as `@internal` and subject to unannounced changes.
