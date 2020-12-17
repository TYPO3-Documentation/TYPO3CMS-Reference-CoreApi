.. include:: /Includes.rst.txt
.. index::
   Relational database management system
   see: RDBMS; Relational database management system
   MySQL
   MariaDB
   PostgreSQL
   SQLServer
.. _Database_Introduction:

============
Introduction
============

TYPO3 CMS relies on storing its data in a relational database management
system (RDBMS). The Doctrine DBAL component is used to enable connecting to
different database management systems. Most used is still MySQL / MariaDB, but
thanks to Doctrine others like PostgreSQL and SQLServer are also an option.

The corresponding DBMS can be selected during installation.

.. note::
  At the time of writing the installation process does not fully work for
  SQL Server, the connection settings have to be manually configured in that case.

This chapter gives an overview of the basic TYPO3 database table structure, followed
by some information on upgrading and maintaining table and field consistency, and then
deep dives into the programming API.

.. index::
   ! Doctrine
   Doctrine; DBAL
   Database; Abstraction layer
   Database; DBAL
   $GLOBALS; TYPO3_DB
   DBMS

Doctrine DBAL
=============

Database queries in TYPO3 are done with an API based on
`Doctrine DBAL <http://www.doctrine-project.org/projects/dbal.html>`__.
The API is provided by the system extension `core` which is always loaded and
thus always available.

Extension authors can use this low-level `API` to manage query operations
directly on the configured `DBMS`.

Doctrine DBAL is feature rich. Drivers for various target systems enable
TYPO3 to run on a long list of `ANSI SQL` compatible `DBMS`. If used properly,
queries created with this API are translated to the specific database engine by
doctrine without an extension developer taking care of that specifically.

The API provided by the core is basically a pretty small and lightweight facade
in front of Doctrine DBAL that adds some convenient methods as well as some
`TYPO3 CMS` specific sugar. The facade additionally provides methods to retrieve
specific connection objects per configured database connection based on the table
that is queried. This enables instance administrators to configure different database
engines for different tables while this is transparent for extension developers.

Doctrine DBAL has been introduced with TYPO3 CMS version 8 and substitutes the
old API based on :php:`$GLOBALS['TYPO3_DB']`. Extension authors are encouraged to switch
away from TYPO3_DB to the new API. A :ref:`dedicated chapter <database-migration>` helps
with typical migration questions. With database abstraction being built in Doctrine DBAL
the old and optional extensions `dbal` and `adodb` are obsolete.

This document does *not* outline each and every single method the API provides. It
sticks to those that are commonly used in extensions and some parts like the rewritten
schema migrator are left out since they are usually of little to no interest for
extensions.

.. index:: Doctrine; ORM

Understanding Doctrine DBAL and Doctrine ORM
============================================

Doctrine is a two-fold project with `Doctrine DBAL <http://www.doctrine-project.org/projects/dbal.html>`__
being the low-level database abstraction and query building interface to specific database engines, while
`Doctrine ORM <http://www.doctrine-project.org/projects/orm.html>`__
is a high-level object relational mapping on top of Doctrine DBAL.

The TYPO3 CMS core - only - implements the dbal part. `Doctrine ORM` is neither required nor
implemented nor used at the time of this writing.

.. index::
   Database;  Low-level calls
   DataHandler

Low-level and high-level database calls
=======================================

This documentation is about low-level database calls. In many cases it is better
to use higher level API's like the :ref:`DataHandler <tce-database-basics>` or
:ref:`Extbase repositories <t3extbasebook:persistence>`
and to let the framework handle persistence details internally.

.. tip::

   Always remember the **high-level** database calls and use them when appropriate!


Credits
=======

Implementing the Doctrine DBAL API into `TYPO3` has been a *huge project in 2016.*
Special thanks goes to awesome Mr. **Morton Jonuschat** for the initial design, integration
and support and to more than **40 different people** who actively contributed to migrate
more than 1700 calls from `TYPO3_DB`-style to Doctrine within half a year.
**This was a huge community achievement, thanks everyone involved!**
