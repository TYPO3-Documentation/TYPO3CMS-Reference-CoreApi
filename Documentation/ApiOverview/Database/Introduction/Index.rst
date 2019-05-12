.. include:: ../../../Includes.txt

.. _Database_Introduction:

============
Introduction
============

TYPO3 CMS relies on storing its data in a Relational database management
system (RDBMS). The doctrine-dbal component is used to enable connecting to
different database management systems. Most used is still MySQL / MariaDB, but
thanks to Doctrine others like PostgreSQL and SQLServer are also an option.

The corresponding DBMS can be selected during installation.

.. note::
  At the time of writing the installation process does not fully work for
  SQL Server, the connection settings have to be manually configured in that case.

This chapter gives an overview of the basic TYPO3 database table structure, followed
by some information on upgrading and maintaining table and field consistency, and then
deep dives into the programming API.


Doctrine-Dbal
=============

Database queries in TYPO3 are done with an API based on
`doctrine-dbal <http://www.doctrine-project.org/projects/dbal.html>`__.
The API is provided by the system extension `core` which is always loaded and
thus always available.

Extension authors can use this low-level `API` to manage query operations
directly on the configured `DBMS`.

Doctrine-dbal is feature rich. Drivers for various target systems enable
TYPO3 to run on a long list of `ANSI SQL` compatible `DBMS`. If used properly,
queries created with this API are translated to the specific database engine by
doctrine without an extension developer taking care of that specifically.

The API provided by the core is basically a pretty small and lightweight facade
in front of `doctrine-dbal` that adds some convenient methods as well as some
`TYPO3 CMS` specific sugar. The facade additionally provides methods to retrieve
specific connection objects per configured database connection based on the table
that is queried. This enables instance administrators to configure different database
engines for different tables while this is transparent for extension developers.

`doctrine-dbal` has been introduced with TYPO3 CMS version 8 and substitutes the
old API based on :php:`$GLOBALS['TYPO3_DB']`. Extension authors are encouraged to switch
away from TYPO3_DB to the new API. A :ref:`dedicated chapter <database-migration>` helps
with typical migration questions. With database abstraction being built in `doctrine-dbal`
the old and optional extensions `dbal` and `adodb` are obsolete.

This document does *not* outline each and every single method the API provides. It
sticks to those that are commonly used in extensions and some parts like the rewritten
schema migrator are left out since they are usually of little to no interest for
extensions.


Understanding Doctrine-Dbal and Doctrine-Orm
============================================

Doctrine is a two-fold project with `doctrine-dbal <http://www.doctrine-project.org/projects/dbal.html>`__
being the low-level database abstraction and query building interface to specific database engines, while
`doctrine-orm <http://www.doctrine-project.org/projects/orm.html>`__
is a high-level object relational mapping on top of `doctrine-dbal`.

The TYPO3 CMS core - only - implements the dbal part. `doctrine-orm` is neither required nor
implemented nor used at the time of this writing.


Low-level and High-Level Database Calls
=======================================

This documentation is about low-level database calls. In many cases it is better
to use higher level API's like the :ref:`DataHandler <tce-database-basics>` or
`extbase repositories <https://docs.typo3.org/typo3cms/ExtbaseFluidBook/2-BasicPrinciples/2-Domain-Driven-Design.html>`__
and to let the framework handle persistence details internally.

.. tip::

   Always remember the **high-level** database calls and use them when appropriate!


Credits
=======

Implementing the `doctrine-dbal` API into `TYPO3` has been a *huge project in 2016.*
Special thanks goes to awesome Mr. **Morton Jonuschat** for the initial design, integration
and support and to more than **40 different people** who actively contributed to migrate
more than 1700 calls from `TYPO3_DB`-style to Doctrine within half a year.
**This was a huge community achievement, thanks everyone involved!**
