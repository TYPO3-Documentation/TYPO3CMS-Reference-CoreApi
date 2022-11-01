.. include:: /Includes.rst.txt

.. index:: Extbase; Annotations
.. _extbase-annotations:

===========
Annotations
===========

All available annotations for Extbase are placed within the namespace
:php:`TYPO3\CMS\Extbase\Annotation`.

..  versionchanged:: 12.0
    Starting with TYPO3 v12.0 Extbase annotations can be supplied as
    `PHP 8 native attributes <https://www.php.net/manual/en/language.attributes.overview.php>`.

..  attention::
    Even if you use PHP 8.0 with TYPO3 11LTS native attributes do not work below
    TYPO3 v12.0. To stay compatible with bot TYPO3 v11 and v12 continue to use
    the Extbase annotations as doc-block comments.

Example in EXT:blog_example for the annotation :php:`Lazy`:

..  literalinclude:: _Annotations/_Lazy.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

Annotations provided by Extbase
===============================

The following annotations are provided Extbase:

.. _extbase-annotation-validate:

Validate
--------

:php:`TYPO3\CMS\Extbase\Annotation\Validate`: Allows to configure validators
for properties and method arguments. See :ref:`extbase_validation` for details.

Can be used in the context of a model.

**Example:**

..  literalinclude:: _Annotations/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

.. _extbase-annotation-ignore-validation:

IgnoreValidation
----------------

:php:`TYPO3\CMS\Extbase\Annotation\IgnoreValidation()`: Allows to ignore
Extbase default validation for a given argument.

Used in context of a controller.

**Example:**

..  literalinclude:: _Annotations/_IgnoreValidation.php
    :caption: EXT:blog_example/Classes/Controller/BlogController.php, modified

.. _extbase-annotation-orm:

ORM (object relational model) annotations
------------------------------------------

The following annotations can only be used on models:

.. _extbase-annotation-cascade:

Cascade
~~~~~~~

:php:`TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")`: Allows to remove
child entities during deletion of aggregate root.

Extbase only supports the option "remove".

**Example:**

..  literalinclude:: _Annotations/_Cascade.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

.. _extbase-annotation-transient:

Transient
~~~~~~~~~~

:php:`TYPO3\CMS\Extbase\Annotation\ORM\Transient`: Marks property as transient
(not persisted).

**Example:**

..  literalinclude:: _Annotations/_Transient.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

.. _extbase-annotation-lazy:

Lazy
~~~~

:php:`TYPO3\CMS\Extbase\Annotation\ORM\Lazy`: Marks property to be lazily
loaded on first access.

.. note::
   Lazy loading can greatly improve the performance of your actions.

**Example:**

..  literalinclude:: _Annotations/_Lazy.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

.. _extbase-annotation-combine:

Combining annotations
=====================

Annotations can be combined. For example Lazy loading and removal on cascade
are frequently combined:

..  literalinclude:: _Annotations/_Multiple.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

Several validations can also be combined. See :ref:`extbase_validation`
for details.
