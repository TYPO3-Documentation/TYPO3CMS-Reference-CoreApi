:navigation-title: Tables

..  include:: /Includes.rst.txt
..  index::
    Database; Structure
    Tables
..  _database-structure:
..  _database-structure-requirements:

=============================
Database structure and tables
=============================

Types of tables
===============

The database tables used by TYPO3 can be roughly divided into two categories:

Internal tables
---------------

Tables that are used internally by the system and are invisible to backend users
(for example, :sql:`be_sessions`, :sql:`sys_registry`, cache-related tables). In
the Core extension, there are often dedicated PHP APIs for managing entries in
these tables, for instance, the :ref:`caching framework API <caching>`.

Managed tables
--------------

Tables that can be managed via the TYPO3 backend are shown in the
:guilabel:`Web > List` module and can be edited using the :ref:`FormEngine
<FormEngine>`.

Requirements
~~~~~~~~~~~~

There are certain requirements for such managed tables:

-   The table must be configured in the :ref:`global TCA array <t3tca:start>`,
    for example:

    -   table name
    -   features that are required
    -   fields of the table and how they should be rendered in the backend
    -   relations to other tables

    and so on.

-   The table must contain at least these fields:

    -   :sql:`uid` - an auto-incremented integer and primary key for the table,
        containing the *unique ID* of the record in the table.
    -   :sql:`pid` - an integer pointing to the :sql:`uid` of the page (record
        from :sql:`pages` table) to which the record belongs.

    The fields are created automatically when the table is associated
    with a TCA configuration.


Typical fields
~~~~~~~~~~~~~~

-   A :sql:`title` field holding the title of the record as seen in the backend.

-   A :sql:`description` field holding a description displayed in the
    :guilabel:`Web > List` view.

-   A :sql:`crdate` field holding the creation time of the record.

-   A :sql:`tstamp` field holding the last modification time of the record.

-   A :sql:`sorting` field holding an order when records are sorted manually.

-   A :sql:`deleted` field which tells TYPO3 that the record is deleted
    (actually implementing a "soft delete" feature; records with a
    :sql:`deleted` field are not truly deleted from the database).

-   A :sql:`hidden` or :sql:`disabled` field for records which exist but should
    not be used (for example, disabled backend users, content not visible in the
    frontend).

..  note::
    With the exception of the :sql:`uid` and :sql:`pid` fields, all other fields
    do not automatically fill a role as soon as they exist. Their existence must
    be declared in the :ref:`TCA configuration <t3tca:ctrl>`. This means that
    such fields can also be named freely, the above are the default names TYPO3
    uses - for consistency reasons it is recommended to name them that way.


..  index:: Tables; pages
..  _database-structure-pages:

The "pages" table
=================

The :sql:`pages` table has a special status: It is the backbone of TYPO3, as it
provides the hierarchical page structure into which all other records managed by
TYPO3 are placed. All other managed tables in TYPO3 have a :sql:`pid`
field that points to a :sql:`uid` record in this table. Thus, each managed table
record in TYPO3 is always placed on exactly one page in the page tree. This
makes the :sql:`pages` table the mother of all other managed tables. It can be
seen as a directory tree with all other table records as files.

Standard pages are literally website pages in the frontend. But they can also be
storage spaces in the backend, similar to folders on a hard disk. For each
record, the :sql:`pid` field contains a reference to the page where that
record is stored. For pages, the :sql:`pid` fields behaves as a reference to
their parent pages.

The special "root" page has some unique properties: its :sql:`pid` is 0 (zero),
it does not exist as a row in the :sql:`pages` table, only users with
administrative rights can access records on it, and these records must be
:ref:`explicitly configured to reside in the root page
<t3tca:ctrl-reference-rootlevel>` - usually, table records can only be created
on a real page.


..  index::
    Tables; MM relations
..  _database-structure-mm-relations:


MM relations
============

When tables are connected via a many-to-many relationship, another table must
store these relations. Examples are the table storing relations between
:ref:`categories <categories>` and categorized records
(:sql:`sys_category_record_mm`) or the table storing relations between files
and their various usages in pages, content elements, etc.
(:sql:`sys_file_reference`). The latter is an interesting example, because it
actually appears in the backend, although only as part of
:ref:`inline records <t3tca:columns-inline>`.


..  index::
    Tables; Cache
    Tables; System information
..  _database-structure-other-tables:

Other tables
============

The internal tables which are not managed through the TYPO3 backend serve
various purposes. Some of the most common are:

-   Cache: If a :ref:`cache <caching>` is defined to use the database as a
    :ref:`cache backend <caching-backend>`, TYPO3 automatically creates and
    manages the relevant cache tables.

-   System information: There are tables that store information about
    :ref:`sessions <sessions>`, both frontend and backend (:sql:`fe_sessions`
    and `be_sessions`  respectively), a table for a central registry
    (:sql:`sys_registry`) and some others.

All these tables are not subject to the :sql:`uid`/:sql:`pid` constraint
mentioned above, but they may have such fields if it is convenient for some
reason.

There is no way to manage such tables through the TYPO3 backend, unless a
specific module provides some form of access to them. For example, the
:guilabel:`System > Log` module provides an interface for browsing records
from the :sql:`sys_log` table.
