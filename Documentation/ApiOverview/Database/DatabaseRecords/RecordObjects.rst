:navigation-title: Record objects

..  include:: /Includes.rst.txt
..  _record_objects:

==============
Record objects
==============

Record objects are instances of :php:`\TYPO3\CMS\Core\Domain\Record`.

They are an advanced data object holding the data of a database row, taking the
:ref:`TCA definition <t3tca:start>` and possible relations of that database row
into account.

..  note::

    The Record object is available but still considered experimental. Only the
    usage in Fluid is public API.

..  _record_objects_typoscript:

Provide records in TypoScript
=============================

In TypoScript you can use the
:ref:`RecordTransformationProcessor <t3tsref:RecordTransformationProcessor>`,
usually in combination with the :ref:`DatabaseQueryProcessor <t3tsref:DatabaseQueryProcessor>`
to pass record objects to the Fluid templating engine.

..  _record_objects_php:

Provide records in PHP
======================

In PHP a record object can be created by the
:php:`\TYPO3\CMS\Core\Domain\RecordFactory`.

The event :ref:`RecordCreationEvent <RecordCreationEvent>` can be used to
influence or replace the Record object and its properties during creation.

..  _record_objects_fluid:

Use records in Fluid
====================

In frontend templates the record object is provided by
:ref:`TypoScript <record_objects_typoscript>` or passed to Fluid by a
:ref:`PHP class <record_objects_php>`.

Content element preview templates automatically receive a record object
representing the record of the content element that should currently be displayed.

..  todo: Link Content element preview templates once documented

The :ref:`f:debug ViewHelper <t3viewhelper:typo3-fluid-debug>` output
of the Record object is misleading for integrators,
as most properties are accessed differently as one would assume.

We are dealing with an object here. You however can access your record
properties as you are used to with :fluid:`{record.title}` or
:fluid:`{record.uid}`. In addition, you gain special, context-aware properties
like the language :fluid:`{record.languageId}` or workspace
:fluid:`{data.versionInfo.workspaceId}`.

Overview of all possibilities:

..  literalinclude:: _CodeSnippets/_FluidUsage.fluid.html
    :caption: Demonstration of available variables in Fluid

..  _record_objects_fluid-raw:

Using the raw record
--------------------

The :php-short:`\TYPO3\CMS\Core\Domain\RecordFactory` object contains
only the properties, relevant for
the current :ref:`record type <database-records-types>`, for example `CType`.
In case you need to access properties, which are not defined for the record
type, the "raw" record can be used by accessing it via
:fluid:`{record.rawRecord}`. Those properties are not transformed.

..  _record_objects_resolved_values:

Field values a record object resolves from TCA
==============================================

A record object does not contain the raw database value of a field. The
:php-short:`\TYPO3\CMS\Core\Domain\RecordFactory` reads the TCA type of
each field of the current :ref:`record type <database-records-types>`. It then
replaces the raw value with the data that this type describes.

A field of the relation types :ref:`category <t3tca:columns-category>`,
:ref:`group <t3tca:columns-group>`, :ref:`inline <t3tca:columns-inline>` or
:ref:`select <t3tca:columns-select>` with a `foreign_table` contains the
related records as record objects. A field of TCA type
:ref:`file <t3tca:columns-file>` contains
:php:`\TYPO3\CMS\Core\Resource\FileReference` objects. A field of TCA type
:ref:`folder <t3tca:columns-folder>` contains
:php:`\TYPO3\CMS\Core\Resource\Folder` objects, including all subfolders.

TYPO3 resolves a relation when a template reads the field for the first time.
It sends no database query for a field that no template reads. When TYPO3
resolves a field of one record, it also resolves this field of all records
that it fetched together with this record.

TYPO3 converts the other field types as well:

*   A field of TCA type :ref:`datetime <t3tca:columns-datetime>` contains a
    :php:`\DateTimeImmutable` object. An empty nullable field contains `NULL`.
*   A field of TCA type :ref:`json <t3tca:columns-json>` contains the decoded
    JSON value.
*   A field of TCA type :ref:`link <t3tca:columns-link>` contains a
    :php:`\TYPO3\CMS\Core\LinkHandling\TypolinkParameter` object. This
    object provides the parts of the link, for example the URL and the target.
*   A field of TCA type :ref:`country <t3tca:columns-country>` contains a
    :php:`\TYPO3\CMS\Core\Country\Country` object.
*   A field of TCA type :ref:`flex <t3tca:columns-flex>` contains the values of
    the FlexForm. TYPO3 resolves these values by the same rules and addresses
    them by sheet and field name.
*   A field of TCA type :ref:`select <t3tca:columns-select>` without a
    `foreign_table` contains an array of the selected values. A field with
    `renderType = selectSingle` contains the single value.

..  _record_objects_resolved_cardinality:

Cardinality of a relation in a record object
--------------------------------------------

A relation field contains a collection of records, even when it allows one
record only. Set the TCA option `relationship` to declare the cardinality. A
field with the value `oneToOne` or `manyToOne` contains the related record
itself. It contains `NULL` when TYPO3 cannot resolve the relation.

The option takes the values `oneToOne`, `manyToOne`, `oneToMany` and
`manyToMany`. The TCA reference describes it for TCA type `category` in the
:ref:`relationship option <t3tca:columns-category-properties-relationship>`.

The option `maxitems` does not declare a cardinality. A field without
`relationship` contains a collection, even when `maxitems` allows one record
only.

..  literalinclude:: _CodeSnippets/_RelationshipTca.php
    :caption: packages/my_extension/Configuration/TCA/tx_myextension_domain_model_item.php
    :visible-lines: 11-20

..  _record_objects_resolved_example:

Use the resolved relations of a record object in Fluid
------------------------------------------------------

..  literalinclude:: _CodeSnippets/_ResolvedRelations.fluid.html
    :caption: packages/my_extension/Resources/Private/Templates/Preview/Item.html
