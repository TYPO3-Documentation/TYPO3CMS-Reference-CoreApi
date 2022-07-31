.. include:: /Includes.rst.txt

.. index:: Extbase; Model

===================================
Model
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


