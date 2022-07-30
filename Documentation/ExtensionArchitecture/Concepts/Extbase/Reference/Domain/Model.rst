.. include:: /Includes.rst.txt

.. index:: Extbase; Domain

===================================
Domain and model
===================================

The Application domain of the extension is always located below
:file:`Classes/Domain`. This folder is structured as follows:

:file:`Model/`
    Contains the domain models themselves.

:file:`Repository/`
    It contains the repositories to access the domain models.

:file:`Validator/`
    Contains specific validators for the domain models.


.. index:: Extbase; Domain models

Domain model
===================================

All classes of the domain model must inherit from one of the following classes:

:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`
    It is used if the object possesses identity and continuity.

:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject`
    Is used if the object is defined only by all of its properties.
    ValueObjects are immutable.

AbstractEntity
--------------

An entity is an object fundamentally defined not by its attributes, but by a
thread of continuity and identity for example a person or a blog post.

Objects stored in the database are usually entities as they can be identified
by the :sql:`uid` and are persisted, therefore have continuity.

**Example:**

.. include:: /CodeSnippets/Extbase/Domain/AbstractEntity.rst.txt

AbstractValueObject
--------------------

A value object is an object that describes some characteristic
or attribute (for example a color) but carries no concept of identity.

.. attention::
   The class :php:`AbstractValueObject` has been marked as
   :php:`@internal` since TYPO3 9.5. It might be removed in the future.

**Example:**

.. include:: /CodeSnippets/Extbase/Domain/AbstractValueObject.rst.txt

.. index:: Extbase; Repositories

Repositories
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

