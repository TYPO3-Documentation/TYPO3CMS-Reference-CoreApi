:navigation-title: Database compare

..  include:: /Includes.rst.txt
..  index:: Database; Upgrade
..  _database-upgrade:

===============================================
Database compare during update and installation
===============================================

Whenever you install or update an extension, or change the
`TCA definition <https://docs.typo3.org/permalink/t3tca:start>`_ or the
:ref:`ext_tables.sql <database-exttables-sql>` of an extension, the database
schema might have changed.

..  figure:: /Images/ManualScreenshots/AdminTools/AnalyzeDatabase.png
    :alt: TYPO3 backend with the Maintenance Admin Tools. The database analyzer is highlighted.

    System maintainers can compare the database schema and apply changes here.

..  contents:: Table of contents

..  _database-upgrade-compare:

Compare the database schema and apply changes
=============================================

Users with
`System Maintainer privileges
<https://docs.typo3.org/permalink/t3coreapi:system-maintainer>`_ can use the
:guilabel:`Analyze Database Structure` section in the
:guilabel:`Admin Tools > Maintenance` module to compare the defined schema
with the current one. The module offers options to align the two by adding,
removing, or updating columns.

You can also use the console command `typo3 extension:setup` to add tables
and columns defined by an installed or updated extension:

..  tabs::

    ..  group-tab:: Composer-based installation

        ..  code-block:: bash

            vendor/bin/typo3 extension:setup

    ..  group-tab:: Classic installation

        ..  code-block:: bash

            typo3/sysext/core/bin/typo3 extension:setup

..  _database-upgrade-add:

Adding columns and tables is safe
=================================

Adding additional columns or tables is not problematic. You can safely add any
column shown as missing.

..  _database-upgrade-delete:

Deleting columns or tables: be careful
======================================

Columns suggested for deletion might still be needed by
`upgrade wizards <https://docs.typo3.org/permalink/t3coreapi:upgrade-wizards>`_.

Before deleting tables or columns using the database analyzer:

*  Run all upgrade wizards
*  Make a database backup

Some third-party extensions may rely on database columns or tables they do not
explicitly define. Removing them could cause these extensions to break.

..  _database-upgrade-change:

Changing a column type: it depends
==================================

Some column changes extend capabilities and are safe. For example:

*  Changing from :sql:`TEXT` to :sql:`LONGTEXT` allows storing more data
   and does not affect existing content.

Other changes can cause problems if existing data violates the new definition.
For instance:

*  Changing from :sql:`NULL` to :sql:`NOT NULL` will fail if any row,
   including **soft-deleted** ones (`deleted = 1`), still contains `NULL`.

Some extensions provide upgrade wizards to clean or convert data. Note that
many wizards ignore soft-deleted records. Deleting unnecessary soft-deleted
records may help.

..  _database-upgrade-conflict:

Conflicting column definitions
==============================

The effective :ref:`database structure <database-structure>` is defined by the
`Table Configuration Array (TCA) <https://docs.typo3.org/permalink/t3tca:start>`_
and, optionally, by definitions in an extension's :file:`ext_tables.sql`.

If two extensions define the same column in conflicting ways, the definition
from the extension
`loaded last <https://docs.typo3.org/permalink/t3coreapi:extension-loading-order>`_
will take precedence.

Therefore, an extension that changes or adds columns to a table **must**
declare a dependency on the original extension to ensure proper load order.
