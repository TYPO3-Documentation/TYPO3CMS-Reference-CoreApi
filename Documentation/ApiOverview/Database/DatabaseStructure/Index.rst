.. include:: ../../../Includes.txt


.. _database-structure:
.. _database-structure-requirements:

Database Structure
^^^^^^^^^^^^^^^^^^

The database tables used by TYPO3 CMS can be divided into two
rough categories:

- Tables that are used by the system internally and are invisible to backend
  users (eg. `be_sessions`, `sys_registry`, cache related tables). There are
  often dedicated PHP API's in the core extension to manage entries of these
  tables, for instance the :ref:`Cache framework API <caching>`.

- Tables that can be managed via the TYPO3 CMS backend, are shown in the List
  module and can be edited using :ref:`FormEngine <FormEngine>`.

There are certain requirements for such managed tables:

- The table must be configured in the :ref:`global TCA array <t3tca:start>`.
  This will tell TYPO3 CMS things like the table name,
  features you have configured, the fields of the table and how to
  render these in the backend, relations to other tables, etc.

- The table must contain at least these fields:

  - "uid" - an auto-incremented integer, PRIMARY key, for the table,
    containing the *unique ID* of the record in the table.

  - "pid" - an integer pointing to the "uid" of the page (record from
    "pages" table) to which the record belongs.

  - other typical fields include:

    - A "title" field holding the records title as seen in the backend.

    - A "description" field holding a description displayed in **WEB > List** view.

    - A "crdate" field holding the creation time of the record.

    - A "tstamp" field holding the last modification time of the record.

    - A "sorting" field holding an order if records are sorted manually.

    - A "deleted" field which tells TYPO3 CMS that the record is deleted
      (in effect implementing a "soft delete" feature; records with a
      "deleted" field are not truly deleted from the database).

    - A "hidden" or "disabled" field for records which exist but should not
      be used (e.g. disabled backend users, content not visible in the frontend).

.. note::

   Except for the "uid" and "pid" fields, all other fields do not fill a role
   automatically as soon as they exist. Their existence must be declared in
   the :ref:`TCA configuration <t3tca:ctrl>`. This means that such fields can
   also be named freely, the above are the default names TYPO3 uses - for
   consistency it is recommended to name them that way.


.. _database-structure-pages:

The "pages" table
"""""""""""""""""

The `pages` table has a special status: It is the backbone of TYPO3 CMS, as it provides
the hierarchical page structure into which all other TYPO3 CMS managed records are positioned.
All other managed tables in TYPO3 have a `pid` field that points to a `uid` record in this table.
So any managed table record in TYPO3 is always positioned on exactly one page in the page tree.
This makes the `pages` table the mother of all other managed tables. It can be seen as a directory
tree with all other table records as files.

Standard pages are quite literally web site pages in the frontend. But they can also be storage
spaces in the backend, very much like folders on a hard disk. For any record, the "pid" field
contains a reference to the page where that record is stored. For pages, the "pid" fields behaves
as a reference to their parent pages.

The special "root" page has some unique properties: its pid is 0 (zero), it does not exist as
a row in the `pages` table, only admin-users can access records on it and these records have
to be :ref:`explicitly configured to reside in the root page <t3tca:ctrl-reference-rootlevel>` - usually
table records may only be created on a real page.


.. _database-structure-other-tables:

Other tables
""""""""""""

The tables which are not managed via the TYPO3 CMS backend fill various
roles. Some of the most common are:

- MM relations: when tables are related using a many-to-many relationship,
  another table must hold these relations. Examples are the table storing
  relations between categories and categorized records
  ("sys\_category\_record\_mm") or the table storing relations
  between files and their various usages in pages, content elements, etc.
  ("sys\_file\_reference"). The latter is an interesting example,
  because it does actually appear in the backend, although only
  as part of :ref:`inline records <t3tca:columns-inline>`.

- cache: when a cache is defined as using the database as a cache backend,
  TYPO3 CMS will automatically create and manage the relevant cache tables.

- system information: there exist tables storing information about sessions,
  both frontend and backend ("fe\_sessions" and "be\_sessions" respectively),
  a table for a central registry ("sys\_registry") and quite a few others.

All these tables are not subject to the uid/pid constraint mentioned
above, but they may have such fields if it is convenient for whatever
reason.

There is no way such tables can be managed via the TYPO3 CMS
backend unless a specific module provides a form of access to it.
For example, the **SYSTEM > Log** module provides an interface
to browse records from the "sys\_log" table.
