:navigation-title: Tables

..  include:: /Includes.rst.txt
..  _database-structure:
..  _database-structure-requirements:

=============================
Database structure and tables
=============================

TYPO3 distinguishes between **internal** and **managed** tables.

..  contents:: Table of contents

..  _database-structure-other-tables:

Internal tables
===============

Used internally by TYPO3 and not accessible in the backend (e.g. tables such as
:sql:`be_sessions`, :sql:`sys_registry`, cache tables). They are accessed via TYPO3
APIs such as the :ref:`caching framework <caching>`. These tables are not
editable unless a specific backend module provides access.

Typical categories include:

*   **Cache tables**: Created automatically when using a database-based cache
    backend
*   **Session tables**: :sql:`fe_sessions`, :sql:`be_sessions`
*   **System tables**:

    *   :sql:`sys_registry`: Global configuration
    *   :sql:`sys_log`: Viewable via :guilabel:`Administration > Log`

..  _database-structure-managed:

Managed tables
==============

Defined in the :ref:`TCA <t3tca:start>` and, by default, editable in the
:guilabel:`Content > Records` module. TYPO3 derives database schemas from the TCA
configuration. Required fields such as :sql:`uid` and :sql:`pid` are generated
automatically.

**Required fields:**

*   :sql:`uid`: Primary key (auto-incremented)
*   :sql:`pid`: Page reference (from the :sql:`pages` table)

**Typical fields:**

*   :sql:`title`: Title displayed in backend lists
*   :sql:`crdate`: Creation timestamp
*   :sql:`tstamp`: Last modification timestamp
*   :sql:`sorting`: Manual sort order
*   :sql:`deleted`: Soft delete flag
*   :sql:`hidden` or :sql:`disabled`: Visibility control

These fields and their behavior are defined in the
`table properties (ctrl section of TCA)
<https://docs.typo3.org/permalink/t3tca:ctrl>`_.

When records are rendered in the backend using the
`FormEngine <https://docs.typo3.org/permalink/t3coreapi:formengine>`_, entries
with the soft delete flag set (:sql:`deleted`) will not be shown.

When querying tables via TypoScript, visibility fields such as :sql:`hidden`,
:sql:`startdate`, and :sql:`enddate` are respected.

If you use the
`DBAL query builder
<https://docs.typo3.org/permalink/t3coreapi:database-query-builder>`_ to access
the database, the
`restriction builder
<https://docs.typo3.org/permalink/t3coreapi:database-restriction-builder>`_
automatically filters records based on visibility fields unless explicitly disabled.

When using an
`Extbase repository
<https://docs.typo3.org/permalink/t3coreapi:extbase-repository>`_, the
`query settings
<https://docs.typo3.org/permalink/t3coreapi:extbase-repository-query-setting>`_
also apply visibility constraints by default, but can be reconfigured to change
this behavior.

..  _database-structure-pages:

The :sql:`pages` table
======================

Defines TYPO3's hierarchical page tree. All managed records reference a
:sql:`pages.uid` via their :sql:`pid`.

*   The root page has `pid = 0` and does not exist as a row in the table.
*   Only administrators can create records on the root level.
*   Tables must explicitly allow root-level records using
    :ref:`t3tca:ctrl-reference-rootlevel`.

..  _database-structure-mm-relations:

Many-to-many (MM) relations
===========================

MM tables store relationships between records. Examples include:

*  :sql:`sys_category_record_mm`: Categories and categorized records
*  :sql:`sys_file_reference`: File usage in content and pages

These tables may appear in the backend if configured via
:ref:`inline records <t3tca:columns-inline>`.
