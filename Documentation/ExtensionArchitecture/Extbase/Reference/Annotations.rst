.. include:: /Includes.rst.txt

.. index:: Extbase; Annotations
.. _extbase-annotations:

===========
Annotations
===========

All available annotations for Extbase are placed within the namespace
:php:`TYPO3\CMS\Extbase\Annotation`.

Example in the blog example for the annotation :php:`Lazy`:

.. include:: /CodeSnippets/Extbase/Annotation/Lazy.rst.txt

Annotations provided by Extbase
===============================

The following annotations are provided Extbase:

.. _extbase-annotation-validate:

Validate
--------

:php:`@TYPO3\CMS\Extbase\Annotation\Validate`: Allows to configure validators
for properties and method arguments. See :ref:`extbase_validation` for details.

Can be used in the context of a model.

**Example:**

.. include:: /CodeSnippets/Extbase/Annotation/Validate.rst.txt

.. _extbase-annotation-ignore-validation:

IgnoreValidation
----------------

:php:`@TYPO3\CMS\Extbase\Annotation\IgnoreValidation()`: Allows to ignore
Extbase default validation for a given argument.

Used in context of a controller.

**Example:**

.. include:: /CodeSnippets/Extbase/Annotation/IgnoreValidation.rst.txt

.. _extbase-annotation-orm:

ORM (object relational model) annotations
------------------------------------------

The following annotations can only be used on models:

.. _extbase-annotation-cascade:

Cascade
~~~~~~~

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")`: Allows to remove
child entities during deletion of aggregate root.

Extbase only supports the option "remove".

**Example:**

.. include:: /CodeSnippets/Extbase/Annotation/Cascade.rst.txt

.. _extbase-annotation-transient:

Transient
~~~~~~~~~~

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Transient`: Marks property as transient
(not persisted).

**Example:**

.. include:: /CodeSnippets/Extbase/Annotation/Transient.rst.txt

.. _extbase-annotation-lazy:

Lazy
~~~~

:php:`@TYPO3\CMS\Extbase\Annotation\ORM\Lazy`: Marks property to be lazily
loaded on first access.

.. note::
   Lazy loading can greatly improve the performance of your actions.

**Example:**

.. include:: /CodeSnippets/Extbase/Annotation/Lazy.rst.txt

.. _extbase-annotation-combine:

Combining annotations
=====================

Annotations can be combined. For example Lazy loading and removal on cascade
are frequently combined:

.. include:: /CodeSnippets/Extbase/Annotation/Multiple.rst.txt

Several validations can also be combined. See :ref:`extbase_validation`
for details.
