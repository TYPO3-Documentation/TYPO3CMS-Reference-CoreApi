:navigation-title: Database

..  include:: /Includes.rst.txt
..  _multi-stage-environment-database-management:

==================================================
Synchronizing database content across environments
==================================================

TYPO3 projects not only manage code and configuration across multiple
environments but also deal with database content and user data.

This chapter focuses on managing **database schema and content**,
covering strategies for synchronizing schema changes, handling personal
data responsibly, and managing content between development, staging,
and production systems.

..  note::

    This chapter is focused on database content only. For managing
    uploaded files, images, and media assets, see
    :ref:`multi-stage-environment-user-upload-management`.

..  _multi-stage-environment-database-schema:

Database schema and structural synchronization
==============================================

TYPO3 manages database schema definitions through:

-   `ext_tables.sql` files provided by extensions.
-   TCA-based definitions for records and tables.

You may also use external tools like Doctrine Migrations or custom scripts
to automate structural changes if your project requires more control.

..  _multi-stage-environment-database-personal-data:

Content and personal data handling
==================================

When copying database content between environments, you must consider
data privacy and regulatory requirements such as GDPR.

Best practices include:

-   Avoid transferring personal or sensitive data to non-production systems.
-   Anonymize or pseudonymize user records and personal information.
-   Limit content synchronization to necessary data only.

Example techniques:

-   Export only selected pages or records.
-   Strip sensitive tables like `fe_users`, `sys_log`, or `cache_*`.
-   Replace personal data with dummy values.
..  _multi-stage-environment-database-import-export:

Import/Export workflows in TYPO3
================================

TYPO3 provides a built-in :doc:`Import/Export module <typo3/cms-impexp:Index#typo3-import-export>`,
:composer:`typo3/cms-impexp`, that allows exporting and importing selected
**database records** as `.t3d` files.

This module is primarily designed to work with structured data stored in
the TYPO3 database, such as:

-   Pages and their content elements
-   Records from system and extension tables

It can **optionally include referenced files**, such as images or user uploads,
when these files are related to exported records. These files are bundled
alongside the `.t3d` export if the option to include files is selected.

Typical use cases include:

-   Moving page trees or content elements between systems.
-   Providing editors with content snapshots for review or duplication.
-   Exporting small sets of records **along with their referenced files**.

Limitations to consider:

-   Exported files may not capture all dependencies or extension-specific data.
-   It may not scale well for large datasets or complete site transfers.
-   Including large file sets can make exports unwieldy.

You can work with
`Export Presets <https://docs.typo3.org/permalink/typo3/cms-impexp:presets>`_
to make the export settings repeatable and consistent.

You can also use the
`Command Line Interface <https://docs.typo3.org/permalink/typo3/cms-impexp:command-line>`_
to automate exports in your CI/CD pipeline or to avoid PHP runtime limitations.


..  _multi-stage-environment-database-reduced-dumps:

Reduced database dumps
======================

In many projects, a **reduced database dump** is used to provide a realistic
yet privacy-compliant dataset for development or staging.

Typical strategies include:

-   Dumping only structure and selected content tables.
-   Excluding sensitive tables such as:

    -     `fe_users`
    -     `be_users`
    -     `sys_log`
    -     `be_sessions`
    -     `cache_*`

Example `mysqldump` commands:

..  code-block:: bash

    # Export the database structure only
    mysqldump --no-data -u user -p database > structure.sql

    # Export the data, excluding sensitive or unnecessary tables
    mysqldump \
        --ignore-table=database.fe_users \
        --ignore-table=database.be_users \
        --ignore-table=database.sys_log \
        --ignore-table=database.be_sessions \
        --ignore-table=database.cache_* \
        -u user -p database > reduced_dump.sql

..  _multi-stage-environment-database-best-practices:

Best practices for sharing database content across environment stages
=====================================================================

-   Separate schema and data handling in your deployment workflow.
-   Avoid copying full production data without anonymization.
-   Use TYPO3 Import/Export for targeted content migration.
-   Document your project's data management strategy.
-   Ensure compliance with data privacy regulations.

..  seealso::

    -   :ref:`Multi-stage environment workflow <multi-stage-environment-workflow>`
    -   :ref:`Configuring environments <environment-configuration>`
    -   :ref:`Synchronizing user-uploaded files <multi-stage-environment-user-upload-management>`
