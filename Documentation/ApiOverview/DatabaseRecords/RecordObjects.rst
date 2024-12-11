:navigation-title: Record objects
..  include:: /Includes.rst.txt
..  _record_objects:

==============
Record objects
==============

..  versionadded:: 13.2
    Record objects have been introduced as an experimental feature.

Record objects are instances of :php:`\TYPO3\CMS\Core\Domain\Record`.

They are an advanced data object holding the data of a database row, taking the
:ref:`TCA definition <t3tca:start>` and possible relations of that database row
into account.

..  note::

    The Record object is available but still considered experimental. Only the
    usage in Fluid is public API.

.. _record_objects_typoscript:

Provide Records in TypoScript
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

The event :ref:`RecordCreationEvent` can be used to influence or replace
the Record object and its properties during creation.

..  _record_objects_fluid:

Use records in Fluid
====================

In frontend templates the record object is provided by
:ref:`TypoScript <record_objects_typoscript>` or passed to Fluid by a
:ref:`PHP class`.

Content element preview templates automatically receive a record object
representing the record of the content element that should currently be displayed.

..  todo: Link Content element preview templates once documented

The :ref:`Debug ViewHelper <f:debug> <t3viewhelper:typo3-fluid-debug>` output
of the Record object is misleading for integrators,
as most properties are accessed differently as one would assume.

We are dealing with an object here. You however can access your record
properties as you are used to with :fluid:`{record.title}` or
:fluid:`{record.uid}`. In addition, you gain special, context-aware properties
like the language :fluid:`{record.languageId}` or workspace
:fluid:`{data.versionInfo.workspaceId}`.

Overview of all possibilities:

..  literalinclude:: _CodeSnippets/_FluidUsage.html
    :caption: Demonstration of available variables in Fluid

.. _record_objects_fluid-raw:

Using the raw record
--------------------

The :php-short:`\TYPO3\CMS\Core\Domain\RecordFactory` object contains
only the properties, relevant for
the current :ref:`record type <database-records-types>`, for example `CType`.
In case you need to access properties, which are not defined for the record
type, the "raw" record can be used by accessing it via
:fluid:`{record.rawRecord}`. Those properties are not transformed.
