.. include:: /Includes.rst.txt

.. index:: Extbase; Repositories

===================================
Repository
===================================

All repositories inherit from :php:`\TYPO3\CMS\Extbase\Persistence\Repository`.

A repository is always responsible for precisely one type of domain object.

The naming of the repositories is important:
If the domain object is, for example, *Blog* (with full name
:php:`FriendsOfTYPO3\BlogExample\Domain\Model\Blog`),
then the corresponding repository is named *BlogRepository* (with the full name
`FriendsOfTYPO3\BlogExample\Domain\Repository\BlogRepository`).

The :php:`\TYPO3\CMS\Extbase\Persistence\Repository` already offers a large
number of usefull functions. Therefore in simple classes extending the
class :php:`Repository` and leaving the class empty otherwise is sufficient.

The :php:`BlogRepository` sets some default orderings and is otherwise empty:

.. include:: /CodeSnippets/Extbase/Domain/BlogRepository.rst.txt

Magic find methods
===================

The class :php:`Repository` creates "magic" methods to find by attributes of
model.

:php:`findBy[Property]`
   Finds all objects with the provided property.

:php:`findOneBy[Property]`
   Returns the first object found with the provided property.

:php:`countBy[Property]`
   Counts all objects with the provided property.

If necessary these methods can also be overridden by implementing them in the
concrete repository.

Custom find methods
====================

Custom find methods can be implemented. They can be used, for example, to filter
by multiple properties, apply a different sorting. They can also be used for
complex queries.

.. attention::
   As Extbase repositories turn the results into objects querying large amounts
   of data is ressource intensive.

**Example:**

The :php:`PostRepository` of the blog example extension implements several
custom find methods, two of those shown below:

.. include:: /CodeSnippets/Extbase/Domain/CustomMethods.rst.txt

Query settings
===============

When the query settings should be used for all methods in the repository,
the should be set in the method :php:`initializeObject()` method.

.. include:: /CodeSnippets/Extbase/Domain/DefaultQuerySettings.rst.txt

.. attention::
   Depending on the query settings hidden or even deleted objects can become
   visible. This might be cause information disclosure. Use with care.

When the query settings should only be changed for a certain method they can be
set in the method itself:

.. include:: /CodeSnippets/Extbase/Domain/SpecialQuerySettings.rst.txt


Repository API
===============

.. include:: /CodeSnippets/Extbase/Api/Repository.rst.txt
