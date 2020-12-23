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

`TYPO3 CMS`:pn: relies on storing its data in a relational database management
system (RDBMS). The `Doctrine`:pn: DBAL component is used to enable connecting to
different database management systems. Most used is still `MySQL`:pn:/ `MariaDB`:pn:, but
thanks to `Doctrine`:pn: others like PostgreSQL and SQLServer are also an option.

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

`Doctrine`:pn: DBAL
===================

Database queries in TYPO3 are done with an API based on
`Doctrine DBAL <http://www.doctrine-project.org/projects/dbal.html>`__.
The API is provided by the system extension `core` which is always loaded and
thus always available.

Extension authors can use this low-level `API` to manage query operations
directly on the configured `DBMS`.

`Doctrine`:pn: DBAL is feature rich. Drivers for various target systems enable
`TYPO3`:pn: to run on a long list of `ANSI SQL` compatible `DBMS`. If used properly,
queries created with this API are translated to the specific database engine by
`Doctrine`:pn: without an extension developer taking care of that specifically.

The API provided by the `Core`:pn: is basically a pretty small and lightweight facade
in front of `Doctrine`:pn: DBAL that adds some convenient methods as well as some
`TYPO3 CMS` specific sugar. The facade additionally provides methods to retrieve
specific connection objects per configured database connection based on the table
that is queried. This enables instance administrators to configure different database
engines for different tables while this is transparent for extension developers.

`Doctrine`:pn: DBAL has been introduced with the`TYPO3 CMS`:pn: version 8 and substitutes the
old API based on :php:`$GLOBALS['TYPO3_DB']`. Extension authors are encouraged to switch
away from TYPO3_DB to the new API. A :ref:`dedicated chapter <database-migration>` helps
with typical migration questions. With database abstraction being built in `Doctrine`:pn: DBAL
the old and optional extensions `dbal` and `adodb` are obsolete.

This document does *not* outline each and every single method the API provides. It
sticks to those that are commonly used in extensions and some parts like the rewritten
schema migrator are left out since they are usually of little to no interest for
extensions.

.. index:: Doctrine; ORM

Understanding `Doctrine`:pn: DBAL and `Doctrine`:pn: ORM
========================================================

`Doctrine`:pn: is a two-fold project with `Doctrine DBAL <http://www.doctrine-project.org/projects/dbal.html>`__
being the low-level database abstraction and query building interface to specific database engines, while
`Doctrine ORM <http://www.doctrine-project.org/projects/orm.html>`__
is a high-level object relational mapping on top of `Doctrine`:pn: DBAL.

The `TYPO3 Core`:pn: - only - implements the dbal part. `Doctrine ORM`:pn: is neither required nor
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

Implementing the `Doctrine`:pn: DBAL API into `TYPO3` has been a *huge project in 2016.*
Special thanks goes to awesome Mr. **Morton Jonuschat** for the initial design, integration
and support and to more than **40 different people** who actively contributed to migrate
more than 1700 calls from `TYPO3_DB`-style to `Doctrine`:pn: within half a year.
**This was a huge community achievement, thanks everyone involved!**
