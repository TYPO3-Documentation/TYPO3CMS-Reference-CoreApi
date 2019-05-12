.. include:: ../../Includes.txt

.. _update-wizards-concept:

=============================
The concept of Update Wizards
=============================

Update wizards are single PHP classes that provide an automated way to update certain
parts of a TYPO3 installation. Usually those affected parts are sections of the
database (e.g. contents of fields change) as well as segments in the file system
(e.g. locations of files have changed).

wizards should be provided to ease updates for integrators and administrators. They
are an addition to the database migration, which is handled by the core based on
:file:`ext_tables.sql`.

The execution order is not defined. Each administrator is able to execute wizards and
migrations in any order. They are also completely skippable.

Each wizard is able to check pre-conditions to prevent execution, if nothing has to
be updated. The wizard can log information and executed SQL statements, that can be
displayed after execution.

Best Practice
=============

Each extension can provide as many update wizards as necessary. Each wizard should do
exactly one specific update.

Examples
========

The TYPO3 core itself provides update wizards inside
:file:`typo3/sysext/install/Classes/Updates/`.
