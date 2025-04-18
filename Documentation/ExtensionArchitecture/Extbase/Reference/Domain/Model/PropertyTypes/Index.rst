:navigation-title: Property types

..  include:: /Includes.rst.txt
..  index:: Extbase; Model
..  _extbase-model-property-types:

================================
Property types of Extbase models
================================

In Extbase models, the type of a property can be defined either through a
native PHP type declaration or via a @var annotation for untyped properties.

For persisted properties, it is important that the PHP property type and the
corresponding TCA field configuration are compatible — see the list below for
commonly used property types and their correct mappings.

..  contents:: Property types in Extbase

..  _extbase-model-property-types-primitive:

Primitive types in Extbase properties
=====================================

The following table lists the primitive PHP types that are commonly used
in Extbase models and the corresponding TCA field types they typically map to:

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
must also be :ref:`nullable <t3tca:confval-input-nullable>`, a checkbox will
appear in the backend, which by default deactivates the field. In the
deactivated state the field is saved as :sql:`NULL` in the database.

..  _extbase-model-property-types-string:

`string` properties in Extbase
------------------------------

Extbase properties of the built-in primitive type :php:`string` are commonly
used with TCA fields of types
`Input <https://docs.typo3.org/permalink/t3tca:columns-input-rendertype-default>`_
(max 255 chars) or `Text areas & RTE <https://docs.typo3.org/permalink/t3tca:columns-text>`_.

Strings can also be used with `Select fields <https://docs.typo3.org/permalink/t3tca:columns-select>`_
that allow a single value an where the values are strings, with the
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
o prevent values that exceed the allowed size for their corresponding
TCA fields / database columns. For virtual fields
(`passthrough <https://docs.typo3.org/permalink/t3tca:columns-passthrough>`_),
you must manually define the database schema in :file:`ext_tables.sql`.

When using a nullable primitive type (:php:`?string`) in your Extbase
model, you must also enable the field to be nullable in the TCA by setting
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
numeric key without a relation to an enum or database record.

These are typically used for rating values, importance levels, custom statuses,
or small fixed sets of choices.

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

While the :php:`int` type is commonly used for simple numeric values,
it should **not** be used in the following cases:

-   **Date and time fields**: For fields configured with
    `datetime <https://docs.typo3.org/permalink/t3tca:columns-datetime>`_,
    use :php:`\DateTimeInterface` instead of :php:`int` to benefit from proper
    time handling and formatting in Extbase and Fluid.

-   **Boolean values**: For fields using
    `check <https://docs.typo3.org/permalink/t3tca:columns-check>`_, use the :php:`bool` type instead of
    :php:`int` to reflect the binary nature (0/1) of the value more clearly.

-   **Multi-value selections**: If a field uses
    `selectMultipleSideBySide <https://docs.typo3.org/permalink/t3tca:columns-select-rendertype-selectmultiplesidebyside>`_
    or similar to store multiple selections
    use :php:`array` or an :php:`ObjectStorage` of related objects.

-   **Enums**: For fixed sets of known numeric values, avoid using :php:`int`
    and instead use a proper :php:`enum` to ensure type safety and
    better readability in your model and templates.

-   **Relations to other database tables**: Fields representing foreign keys
    (for example `select with foreign_table <https://docs.typo3.org/permalink/t3tca:confval-select-single-foreign-table>`_,
    `IRRE / inline <https://docs.typo3.org/permalink/t3tca:columns-inline-introduction>`_,
    or `group <https://docs.typo3.org/permalink/t3tca:columns-group-introduction>`_)
    should not be typed as :php:`int`, but rather use
    :php:`ObjectStorage <YourModel>` or :php:`?YourModel` depending on
    whether the relation is singular or plural.

..  _extbase-model-property-types-float:

`float` properties in Extbase
-----------------------------

Extbase properties of the built-in primitive type :php:`float` (also known as
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

Extbase properties of the built-in primitive type :php:`bool` are used for binary
decisions, such as opting into a feature or accepting terms and conditions.

In TYPO3 v13, boolean values are typically managed using
`Check fields <https://docs.typo3.org/permalink/t3tca:columns-check>`_ with
:php:`renderType: checkboxToggle`, providing a user-friendly toggle UI.

..  tabs::

    ..  group-tab:: Model

        ..  literalinclude:: _codesnippets/_BoolExample.php
            :caption: packages/my_extension/Classes/Domain/Model/BoolExample.php

    ..  group-tab:: TCA

        ..  literalinclude:: _codesnippets/_bool_example.php
            :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_boolexample.php
