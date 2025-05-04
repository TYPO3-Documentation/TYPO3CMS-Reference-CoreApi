:navigation-title: Records

.. include:: /Includes.rst.txt
.. _database-records:

================
Database records
================

In TYPO3, a **record** refers to an individual piece of content or data that
is stored in the database. Each record is part of a table and represents a
specific entity, such as a page, a content element, a backend user, or an
extension configuration.

TYPO3 uses a modular structure where different types of data are managed as
records, making it easy to organize and manipulate content.

Understanding records in TYPO3 is fundamental, as they are the building blocks
for managing content and data within the system.

..  contents::
    :caption: Content on this page

..  toctree::
    :caption: Subpages
    :glob:

    *

..  _database-records-examples:

Common examples of records in TYPO3:
====================================

Page records
    These represent pages in the page tree, which structure the website. They
    are stored in table :sql:`pages`.
Content records
    Every content record consists of sub entities like text, images,
    videos, and so on. Content records can be placed on a page. They are stored
    in table :sql:`tt_content`. TYPO3 has some pre configured content elements
    like for example `Header Only`, `Regular Text Element`, `Text & Images`,
    and `Images Only`.
Backend user records
    The user records consist of information about the users who have access to
    the TYPO3 backend. They are stored in table :sql:`be_users`. Users are
    organized in user groups which are stored in table :sql:`be_groups`.
System records
    System records control the configuration and management of the TYPO3 system.
    Examples include file references, file mounts, or categories. For example,
    you can create a category and assign it to some content records in order to
    indicate that they belong together.
Extension-specific records
    Extensions often define custom records to store specific data, such as
    products for a shop system or events for a calendar.

..  todo: Create a page listing all tables created by the core and explain what
    they do. Link from here

.. _database-records-technical:

Technical structure of a record:
================================

Each record is stored in a database table. Each row represents one record. Each
column represents a field of the record or some kind of metadata.

A record typically includes a unique identifier in column `uid`, the id of the
page record on which it is located in column `pid`, columns for various
attributes (for example, title, content), and metadata like creation and
modification timestamps, visibility, information on translation
and workspace handling. A record can have relations to other records.

.. _database-records-tca:

TCA (Table Configuration Array)
===============================

TYPO3 uses the **TCA** to define how records of a specific table are
structured, how they are displayed in the backend, and how they interact
with other parts of the system. See the :ref:`TCA Reference <t3tca:start>`
for details.

.. _database-records-types:

Types and subtypes in records
-----------------------------

In TYPO3, different types and subtypes of records are often stored in the same
database table, even though not all types share the same columns. This approach
allows for flexibility and efficiency in handling diverse content and data
structures within a unified system.

TYPO3 uses a **single-table inheritance** strategy, where records of various
types are distinguished by a specific field, often named :sql:`type`.
For historical reasons the field is named :sql:`CType` for content elements
and :sql:`doktype` for pages. The field that is used for the type is defined in
TCA in :confval:`ctrl > type <t3tca:ctrl-type>`. The types itself are stored in
:ref:`types <t3tca:types>`.

This allows TYPO3 to store related records, such as different content types,
in a shared table like :sql:`tt_content` while supporting custom
fields for each record type.

For content elements in table :sql:`tt_content` there is a second level of
subtypes in use where the field `CType` contains the value "list" and the field
`list-type` contains the actual type. This second level of types exists for
historic reasons. Read more about it in chapter :ref:`content-element-and-plugin`.

..  _database-record-objects:

Record objects
==============

..  versionadded:: 13.2
    Record objects have been introduced as an experimental feature.

Record objects are instances of :php:`\TYPO3\CMS\Core\Domain\Record` and
contain an object-oriented representation of a database record.

A record object can be used to output a database record in :ref:`Fluid <fluid>`
when no :ref:`Extbase domain model <database-records-models>` is available.

Read more in chapter :ref:`record_objects`.

.. _database-records-models:

Extbase domain models
=====================

TYPO3 extensions based on Extbase typically introduce a class inheriting from
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity` to represent a record
fully or partially within the domain of the extension. Multiple Extbase models
can store their data in the same database table. Additionally, the same record
can be represented in various ways by different Extbase models, depending on
the specific requirements of each model.

See also chapter :ref:`Extbase models <extbase-model>`.
