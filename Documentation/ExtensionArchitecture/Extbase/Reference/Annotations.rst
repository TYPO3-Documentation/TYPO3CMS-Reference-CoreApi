:navigation-title: Annotations

..  include:: /Includes.rst.txt
..  index:: Extbase; Annotations
..  _extbase-annotations:

======================
Annotations in Extbase
======================

All available annotations for Extbase delivered by TYPO3 Core are placed within
the namespace :php:`\TYPO3\CMS\Extbase\Annotation`.

..  versionchanged:: 12.0
    Starting with TYPO3 v12.0 Extbase annotations can be supplied as
    `PHP 8 native attributes <https://www.php.net/manual/en/language.attributes.overview.php>`__.

..  attention::
    Even if you use PHP 8.0 with TYPO3 v11 LTS native attributes do not work below
    TYPO3 v12.0. To stay compatible with both TYPO3 v11 and v12, continue to use
    the Extbase annotations as doc-block comments.

Example in `EXT:blog_example <https://github.com/typo3-documentation/blog_example>`__
for the annotation :php:`Lazy`:

..  literalinclude:: _Annotations/_Lazy.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

..  _extbase-annotations-internal:

Annotations provided by Extbase
===============================

The following annotations are provided Extbase:

..  _extbase-annotation-validate:

Validate
--------

:php:`\TYPO3\CMS\Extbase\Annotation\Validate`: Allows to configure validators
for properties and method arguments. See :ref:`extbase_validation` for details.

Can be used in the context of a model property.

**Example:**

..  literalinclude:: _Annotations/_Validate.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

`Validate` annotations for a controller action are executed additionally
to possible domain model validators.

..  _extbase-annotation-ignore-validation:

IgnoreValidation
----------------

:php:`\TYPO3\CMS\Extbase\Annotation\IgnoreValidation()`: Allows to ignore
all Extbase default validations for a given argument (for example a domain
model object).

Used in context of a controller action.

**Example:**

..  literalinclude:: _Annotations/_IgnoreValidation.php
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

..  _extbase-annotation-orm:

ORM (object relational model) annotations
------------------------------------------

The following annotations can only be used on model properties:

..  _extbase-annotation-cascade:

Cascade
~~~~~~~

:php:`\TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")`: Allows to remove
child entities during deletion of aggregate root.

Extbase only supports the option "remove".

**Example:**

..  literalinclude:: _Annotations/_Cascade.php
    :caption: EXT:blog_example/Classes/Domain/Model/Blog.php, modified

..  _extbase-annotation-transient:

Transient
~~~~~~~~~

:php:`\TYPO3\CMS\Extbase\Annotation\ORM\Transient`: Marks property as transient
(not persisted).

**Example:**

..  literalinclude:: _Annotations/_Transient.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

..  _extbase-annotation-lazy:

Lazy
~~~~

:php:`\TYPO3\CMS\Extbase\Annotation\ORM\Lazy`: Marks model property to be loaded
lazily on first access.

..  note::
   Lazy loading can greatly improve the performance of your actions.

**Example:**

..  literalinclude:: _Annotations/_Lazy.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

..  _extbase-annotation-combine:

Combining annotations
=====================

Annotations can be combined. For example, "lazy loading" and "removal on cascade"
are frequently combined:

..  literalinclude:: _Annotations/_Multiple.php
    :caption: EXT:blog_example/Classes/Domain/Model/Post.php, modified

Several validations can also be combined. See :ref:`extbase_validation`
for details.
