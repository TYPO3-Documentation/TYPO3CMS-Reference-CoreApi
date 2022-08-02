.. include:: /Includes.rst.txt

.. index:: Extbase; Model

===================================
Model
===================================

All classes of the domain model should inherit from the class
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`.

An entity is an object fundamentally defined not by its attributes, but by a
thread of continuity and identity for example a person or a blog post.

Objects stored in the database are usually entities as they can be identified
by the :sql:`uid` and are persisted, therefore have continuity.

**Example:**

.. include:: /CodeSnippets/Extbase/Domain/AbstractEntity.rst.txt



