:navigation-title: Concept

..  include:: /Includes.rst.txt
..  preferably, use label upgrade-wizards-concept
..  index:: Upgrade wizards; Concept
..  _update-wizards-concept:
..  _upgrade-wizards-concept:

==============================
The concept of upgrade wizards
==============================

Upgrade wizards are single PHP classes that provide an automated way to update
certain parts of a TYPO3 installation. Usually those affected parts are sections
of the database (for example, contents of fields change) as well as segments in
the file system (for example, locations of files have changed).

Wizards should be provided to ease updates for integrators and administrators.
They are an addition to the database migration, which is handled by the Core
based on TCA definitions and :ref:`ext_tables.sql <ext-tables-php>`.

The execution order is not defined. Each administrator is able to execute
wizards and migrations in any order. They can also be skipped completely.

Each wizard is able to check pre-conditions to prevent execution, if nothing has
to be updated. The wizard can log information and executed SQL statements, that
can be displayed after execution.

Best practice
=============

Each extension can provide as many upgrade wizards as necessary. Each wizard
should perform exactly one specific update.

Examples
========

The TYPO3 Core itself provides upgrade wizards inside
:t3src:`install/Classes/Updates/`.
