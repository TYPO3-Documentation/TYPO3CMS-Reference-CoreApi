:navigation-title: Attributes

..  include:: /Includes.rst.txt
..  index:: Extbase; Attribute
..  _extbase-annotations:
..  _extbase-attributes:

=====================
Attributes in Extbase
=====================

..  deprecated:: 14.0
    All Extbase attributes have been moved from the namespace
    `\TYPO3\CMS\Extbase\Annotation` to the namespace `\TYPO3\CMS\Extbase\Attribute`.

    A class alias map is provided to allow further usage of the previous
    namespaces. Since the previous namespaces are considered deprecated,
    developers should migrate usages of the attribute classes once dropping
    TYPO3 13 support.

All available attributes for Extbase delivered by TYPO3 Core are placed within
the namespace :php:`\TYPO3\CMS\Extbase\Attribute` and can only be used with the
`native PHP attribute syntax <https://www.php.net/manual/en/language.attributes.overview.php>`_.

..  versionchanged:: 14.0
    Using an attribute with the :composer:`doctrine/annotations` syntax is not
    supported anymore starting with TYPO3 14.0.

Example in `EXT:blog_example <https://github.com/typo3-documentation/blog_example>`__
for the attribute :php:`Lazy`:

..  literalinclude:: _Attributes/_Lazy.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

..  _extbase-annotations-internal:
..  _extbase-attributes-internal:

Attributes provided by Extbase
==============================

The following attributes are provided Extbase:

..  _extbase-annotation-validate:
..  _extbase-attribute-validate:

Validate
--------

:php:`\TYPO3\CMS\Extbase\Attribute\Validate`: Allows to configure validators
for properties and method arguments. See :ref:`extbase_validation` for details.

Can be used in the context of a model property.

**Example:**

..  literalinclude:: _Attributes/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

`Validate` attributes for a controller action are executed additionally
to possible domain model validators.

..  _extbase-annotation-ignore-validation:
..  _extbase-attribute-ignore-validation:

IgnoreValidation
----------------

:php:`\TYPO3\CMS\Extbase\Attribute\IgnoreValidation()`: Allows to ignore
all Extbase default validations for a given argument (for example a domain
model object).

Used in context of a controller action.

**Example:**

..  literalinclude:: _Attributes/_IgnoreValidation.php
    :caption: EXT:blog_example/Classes/Controller/BlogController.php, modified

You can not exclude specific properties of a object specified in an argument.

If you need to exclude certain validators of a domain model, you could adapt
the concept of a "Data Transfer Object" (DTO). You would create a distinct
model variant of the main domain model, and exclude all the properties that
you do not want validation for in your Extbase context, and transport
the contents from and between your original domain model to this instance.
Read more about this on https://usetypo3.com/dtos-in-extbase/ or see a
:abbr:`CRUD (Create, Read, Update, Delete)` example for this on
https://github.com/garvinhicking/gh_validationdummy/

..  warning::
    `IgnoreValidation()` must not be used for domain models supporting
    extbase file uploads, because this leads to a property mapping error.

..  _extbase-annotation-orm:
..  _extbase-attribute-orm:

ORM (object relational model) attributes
----------------------------------------

The following attributes can only be used on model properties:

..  _extbase-annotation-cascade:
..  _extbase-attribute-cascade:

Cascade
~~~~~~~

:php:`\TYPO3\CMS\Extbase\Attribute\ORM\Cascade("remove")`: Allows to remove
child entities during deletion of aggregate root.

Extbase only supports the option "remove".

**Example:**

..  literalinclude:: _Attributes/_Cascade.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

..  _extbase-annotation-transient:
..  _extbase-attribute-transient:

Transient
~~~~~~~~~

:php:`\TYPO3\CMS\Extbase\Attribute\ORM\Transient`: Marks property as transient
(not persisted).

**Example:**

..  literalinclude:: _Attributes/_Transient.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

..  _extbase-annotation-lazy:
..  _extbase-attribute-lazy:

Lazy
~~~~

:php:`\TYPO3\CMS\Extbase\Attribute\ORM\Lazy`: Marks model property to be loaded
lazily on first access.

..  note::
   Lazy loading can greatly improve the performance of your actions.

**Example:**

..  literalinclude:: _Attributes/_Lazy.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

..  _extbase-annotation-combine:
..  _extbase-attribute-combine:

Combining attributes
====================

Attributes can be combined. For example, "lazy loading" and "removal on cascade"
are frequently combined:

..  literalinclude:: _Attributes/_Multiple.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

Several validations can also be combined. See :ref:`extbase_validation`
for details.

..  _extbase-annotation-migration:

Migrate from Extbase annotations to attributes
==============================================

The `native PHP attribute syntax <https://www.php.net/manual/en/language.attributes.overview.php>`_
has been introduced with PHP 8 and is fully supported by Extbase since TYPO3 12.

With TYPO3 14 the annotation syntax is not supported anymore and needs to
be migrated to native PHP attributes:

..  literalinclude:: _Attributes/_Migration.diff

TYPO3 rector (:composer:`sabbelasichon/typo3-rector`) has rule
:php:`\Ssch\TYPO3Rector\TYPO312\v0\ExtbaseAnnotationToAttributeRector` to
automatically migrate from the annotation syntax to the attribute syntax.

..  seealso::
    *   `ExtbaseAnnotationToAttributeRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#extbaseannotationtoattributerector>`_
