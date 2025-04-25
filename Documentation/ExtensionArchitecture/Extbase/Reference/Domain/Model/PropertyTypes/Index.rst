:navigation-title: Property types

..  include:: /Includes.rst.txt
..  index:: Extbase; Model
..  _extbase-model-property-types:

================================
Property types of Extbase models
================================

In Extbase models, property types can be defined either through a
native PHP type declaration or a @var annotation for untyped properties.

For persisted properties, it is important that the PHP property type and the
matching TCA field configuration are compatible — see the list below for
commonly used property types and their mappings.

..  contents:: Property types in Extbase

..  _extbase-model-property-types-primitive:

Primitive types in Extbase properties
=====================================

The following table shows the primitive PHP types that are commonly used
in Extbase models and the TCA field types they typically map to:

===================================================  ================================================================  ============================
PHP Type (section)                                   Common TCA field types                                             Database column types
===================================================  ================================================================  ============================
:ref:`string <extbase-model-property-types-string>`  `input`, `text`, `email`, `password`, `color`,                    `varchar(255)`, `text`
                                                     `select`, `passthrough`
:ref:`int <extbase-model-property-types-int>`        `number` (with `format: integer`), `select` with                  `int(11)`, `tinyint(1)`
                                                     numeric values
:ref:`float <extbase-model-property-types-float>`    `number` (with `format: decimal`)                                 `double`, `float`
:ref:`bool <extbase-model-property-types-bool>`      `check`                                                           `tinyint(1)`
===================================================  ================================================================  ============================

If the primitive PHP type is nullable (`?string`, `?int` ... ) the TCA field
must also be :ref:`nullable <t3tca:confval-input-nullable>`. A checkbox will
appear in the backend, which deactivates the field by default. If the field is
deactivated it is saved as :sql:`NULL` in the database.

..  _extbase-model-property-types-string:

`string` properties in Extbase
------------------------------

Extbase properties of the built-in primitive type :php:`string` are commonly
used with TCA fields of type
`Input <https://docs.typo3.org/permalink/t3tca:columns-input-rendertype-default>`_
(max 255 chars) or `Text areas & RTE <https://docs.typo3.org/permalink/t3tca:columns-text>`_.

Strings can also be used for `Select fields <https://docs.typo3.org/permalink/t3tca:columns-select>`_
that set a single value where the values are strings, for
`Color <https://docs.typo3.org/permalink/t3tca:columns-color>`_ and
`Email <https://docs.typo3.org/permalink/t3tca:columns-email>`_ field types and
`Pass through / virtual fields <https://docs.typo3.org/permalink/t3tca:columns-passthrough>`_.

..  tabs::

    ..  group-tab:: Model

        ..  literalinclude:: _codesnippets/_StringExample.php
            :caption: packages/my_extension/Classes/Domain/Model/StringExample.php

    ..  group-tab:: TCA

        ..  literalinclude:: _codesnippets/_string_example.php
            :caption:  packages/my_extension/Configuration/TCA/tx_myextension_domain_model_stringexample.php

    ..  group-tab:: Database schema

        ..  literalinclude:: _codesnippets/_string_example.sql
            :caption:  packages/my_extension/ext_tables.sql
            :language: sql

If fields are editable by frontend users, you should use
`Validators <https://docs.typo3.org/permalink/t3coreapi:extbase-validation>`_
to prohibit values being input that are not allowed by their corresponding
TCA fields / database columns. For virtual fields
(`passthrough <https://docs.typo3.org/permalink/t3tca:columns-passthrough>`_),
you must manually define the database schema in :file:`ext_tables.sql`.

When using a nullable primitive type (:php:`?string`) in your Extbase
model, you must set the field to nullable in the TCA by setting
:ref:`nullable <t3tca:confval-input-nullable>` to true.

..  _extbase-model-property-types-int:

`int` properties in Extbase
---------------------------

Extbase properties of the built-in primitive type :php:`int` are commonly used
with TCA fields of type
`Number <https://docs.typo3.org/permalink/t3tca:columns-number>`_
(with format integer) and
`Select fields <https://docs.typo3.org/permalink/t3tca:columns-select>`_ that
store integer values — for example, simple option fields where the value is a
numeric key (with no relation to an enum or database record).

These are typically used for ratings, importance levels, custom statuses,
or small, fixed sets of choices.

..  tabs::

    ..  group-tab:: Model

        ..  literalinclude:: _codesnippets/_IntExample.php
            :caption: packages/my_extension/Classes/Domain/Model/IntExample.php

    ..  group-tab:: TCA

        ..  literalinclude:: _codesnippets/_int_example.php
            :caption:  packages/my_extension/Configuration/TCA/tx_myextension_domain_model_intexample.php

..  _extbase-model-property-types-int-when-not:

When not to use type `int` for a property
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The :php:`int` type is commonly used for simple numeric values, but
it should **not** be used in the following cases:

-   **Date and time fields**: For fields configured with
    `datetime <https://docs.typo3.org/permalink/t3tca:columns-datetime>`_,
    use :php:`\DateTimeInterface` instead of :php:`int` to benefit from proper
    time handling and formatting in Extbase and Fluid.

-   **Boolean values**: For fields using
    `check <https://docs.typo3.org/permalink/t3tca:columns-check>`_, use the :php:`bool` type instead of
    :php:`int` to reflect the binary nature (0/1) of the value more clearly. See
    `bool properties <https://docs.typo3.org/permalink/t3coreapi:extbase-model-property-types-bool>`_.

-   **Multi-value selections**: If a field uses
    `selectMultipleSideBySide <https://docs.typo3.org/permalink/t3tca:columns-select-rendertype-selectmultiplesidebyside>`_
    or similar to store multiple selections,
    use :php:`array` or :php:`ObjectStorage` of related objects.

-   **Enums**: For fixed sets of numeric values, avoid using :php:`int`
    and instead use an :php:`enum` to ensure type safety and
    better readability in your model and templates.
    See `Enumerations <https://docs.typo3.org/permalink/t3coreapi:extbase-model-enumerations>`_.

-   **Relations to other database tables**: Fields representing foreign keys
    (for example `select with foreign_table <https://docs.typo3.org/permalink/t3tca:confval-select-single-foreign-table>`_,
    `IRRE / inline <https://docs.typo3.org/permalink/t3tca:columns-inline-introduction>`_,
    or `group <https://docs.typo3.org/permalink/t3tca:columns-group-introduction>`_)
    should not be type :php:`int`, but rather
    :php:`ObjectStorage <YourModel>` or :php:`?YourModel` depending on
    whether the relation is singular or plural. See
    `Relations between Extbase models <https://docs.typo3.org/permalink/t3coreapi:extbase-model-relations>`_.
..  _extbase-model-property-types-float:

`float` properties in Extbase
-----------------------------

Properties of built-in primitive type :php:`float` (also known as
:php:`double`) are used to store decimal values such as prices, ratings, weights,
or coordinates.

In TYPO3 v13, these are typically used with the
`Number <https://docs.typo3.org/permalink/t3tca:columns-number>`_ TCA field type.
To accept and display decimal numbers in the backend form, the
:php:`format` option must be set to ``decimal``.

..  tabs::

    ..  group-tab:: Model

        ..  literalinclude:: _codesnippets/_FloatExample.php
            :caption: packages/my_extension/Classes/Domain/Model/FloatExample.php

    ..  group-tab:: TCA

        ..  literalinclude:: _codesnippets/_float_example.php
            :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_floatexample.php

..  _extbase-model-property-types-bool:

`bool` properties in Extbase
----------------------------

Properties of built-in primitive type :php:`bool` are used for binary
decisions, such as opting in to a feature or accepting terms and conditions.

In TYPO3 v13, boolean values are typically managed using
`Check fields <https://docs.typo3.org/permalink/t3tca:columns-check>`_ with
:php:`renderType: checkboxToggle`, which provides a user-friendly toggle UI.

..  tabs::

    ..  group-tab:: Model

        ..  literalinclude:: _codesnippets/_BoolExample.php
            :caption: packages/my_extension/Classes/Domain/Model/BoolExample.php

    ..  group-tab:: TCA

        ..  literalinclude:: _codesnippets/_bool_example.php
            :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_boolexample.php

..  _extbase-model-enumerations:

Enumerations as Extbase model property
======================================

..  versionadded:: 13.0
    Native support for
    `backed enumerations <https://www.php.net/manual/language.enumerations.backed.php>`__
    has been introduced. It is no longer necessary to extend the deprecated
    TYPO3 Core class :ref:`\\TYPO3\\CMS\\Core\\Type\\Enumeration <Enumerations-How-to-use>`.


Native PHP enumerations can be used for properties, if a database field has a
set of values which can be represented by a backed enum. A property
with an enum type should be used with a TCA field that only allows specific
values to be stored in the database, for example `Select fields <https://docs.typo3.org/permalink/t3tca:columns-select>`_
and `Radio buttons <https://docs.typo3.org/permalink/t3tca:columns-radio>`_.

..  tabs::

    ..  group-tab:: Model

        An enum can be used for a property in the model:

        ..  literalinclude:: _codesnippets/_EnumModelExample.php
            :caption: EXT:my_extension/Classes/Domain/Model/Paper.php

    ..  group-tab:: Enum

        It is recommended to use
        `backed enumerations <https://www.php.net/manual/language.enumerations.backed.php>`_:

        ..  literalinclude:: _codesnippets/_EnumExample.php
            :caption: EXT:my_extension/Classes/Enum/Status.php

        Implementing a method `getLabel()` enables you to use the same
        localization strings in both the Backend (see TCA) and the Frontend (see Fluid).

    ..  group-tab:: TCA

        ..  literalinclude:: _codesnippets/_enum_example.php
            :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_paper.php

        You can use the enums in TCA to display localized labels, for example.

    ..  group-tab:: Fluid

        ..  literalinclude:: _codesnippets/_enum_example.php
            :caption: packages/my_extension/Resources/Private/Templates/Paper/Show.html

    ..  group-tab:: Localization

        ..  literalinclude:: _codesnippets/_enum_locallang.xlf
            :language: php
            :caption: packages/my_extension/Resources/Private/Languages/locallang.xlf

        An enum case can be used in Fluid by calling the enum built-in properties
        `name` and `value` or by using getters. Methods with a different
        naming scheme cannot be used directly in Fluid.

        You can use the `Constant ViewHelper <f:constant> <https://docs.typo3.org/permalink/t3viewhelper:typo3fluid-fluid-constant>`_
        to load a specific enum case into a variable to make comparisons or to
        create selectors.

..  _extbase-model-properties-union-types:

Union types of Extbase model properties
=======================================

..  versionadded:: 12.3
    Previously, whenever a union type was needed, union type declarations led
    Extbase not detecting any type at all, resulting in the property not being
    mapped. However, union types could be resolved via docblocks. Since TYPO3
    v12.3 native PHP union types can be used.

Union types can be used in properties of an entity, for example:

..  literalinclude:: _codesnippets/_UnionType1.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

This is especially useful for lazy-loaded relations where the property type is
:php:`ChildEntity|\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy`.

There is something important to understand about how Extbase detects union
types when it comes to property mapping, that is when a database row is
:ref:`mapped onto an object <extbase-model-hydrating>`. In this situation Extbase
needs to know the specific target type - no union, no intersection, just one
type. In order to do the mapping, Extbase uses the first declared type as a
primary type.

..  literalinclude:: _codesnippets/_UnionType2.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

In the example above, :php:`string` is the primary type. :php:`int|string` would result
in :php:`int` as the primary type.

There is one important thing to note and one exception to this rule. First of
all, :php:`null` is not considered a type. :php:`null|string` results in the
primary type :php:`string` which is :ref:`nullable <extbase-model-nullable-relations>`.
:php:`null|string|int` also results in the primary type :php:`string`. In fact,
:php:`null` means that all other types are nullable. :php:`null|string|int`
boils down to :php:`?string` or :php:`?int`.

Secondly, :php:`LazyLoadingProxy` is never detected as a primary type because it
is just a proxy and, once loaded, not the actual target type.

..  literalinclude:: _codesnippets/_UnionType3.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

Extbase supports this and detects :php:`ChildEntity` as the primary type,
although :php:`LazyLoadingProxy` is the first item in the list. However, it is
recommended to place the actual type first for consistency reasons:
:php:`ChildEntity|LazyLoadingProxy`.

A final word on :php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage`:
it is a subclass of :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`,
therefore the following code works and has always worked:

..  literalinclude:: _codesnippets/_ObjectStorage.php
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php
