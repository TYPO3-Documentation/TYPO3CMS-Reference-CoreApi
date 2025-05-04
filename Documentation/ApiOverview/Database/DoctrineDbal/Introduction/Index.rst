..  include:: /Includes.rst.txt
..  index::
    Relational database management system
    see: RDBMS; Relational database management system
    MySQL
    MariaDB
    PostgreSQL
    SQLite
..  _Database_Introduction:

============
Introduction
============

TYPO3 relies on storing its data in a relational database management
system (RDBMS). The Doctrine DBAL component is used to enable connecting to
different database management systems. Most used is still MySQL / MariaDB, but
thanks to Doctrine others like PostgreSQL and SQLite are also an option.

The corresponding DBMS can be selected during installation.

This chapter gives an overview of the basic TYPO3 database table structure,
followed by some information on upgrading and maintaining table and field
consistency, and then deep dives into the programming API.

..  index::
    ! Doctrine
    Doctrine; DBAL
    Database; Abstraction layer
    Database; DBAL
    DBMS

Doctrine DBAL
=============

Database queries in TYPO3 are done with an API based on `Doctrine DBAL`_.
The API is provided by the system extension `core`, which is always loaded and
thus always available.

Extension authors can use this low-level API to manage query operations
directly on the configured DBMS.

Doctrine DBAL is rich in features. Drivers for various target systems enable
TYPO3 to run on a long list of ANSI SQL-compatible DBMSes. If used properly,
queries created with this API are translated to the specific database engine by
Doctrine without an extension developer taking care of that specifically.

The API provided by the Core is basically a pretty small and lightweight facade
in front of Doctrine DBAL that adds some convenient methods as well as some
TYPO3-specific sugar. The facade additionally provides methods to retrieve
specific connection objects per configured database connection based on the
table that is queried. This enables instance administrators to configure
different database engines for different tables, while being transparent to
extension developers.

This document does *not* outline every single method that the API provides. It
sticks to those that are commonly used in extensions, and some parts like the
rewritten schema migrator are omitted as they are usually of little to no
interest to extensions.

..  index:: Doctrine; ORM

Understanding Doctrine DBAL and Doctrine ORM
============================================

Doctrine is a two-part project, with `Doctrine DBAL`_ being the low-level
database abstraction and the interface for building queries to specific database
engines, while `Doctrine ORM`_ is a high-level object relational mapping on top
of Doctrine DBAL.

The TYPO3 Core implements - only - the DBAL part. Doctrine ORM is neither
required nor implemented nor used.

..  index::
    Database;  Low-level calls
    DataHandler

Low-level and high-level database calls
=======================================

This documentation focuses on low-level database calls. In many cases, it is
better to use higher level APIs such as the :ref:`DataHandler
<datahandler-basics>` or :ref:`Extbase repositories <extbase-repository>` and
to let the framework handle persistence details internally.

..  tip::
    Always remember the **high-level** database calls and use them when
    appropriate!


.. _Doctrine DBAL: https://www.doctrine-project.org/projects/dbal.html
.. _Doctrine ORM: https://www.doctrine-project.org/projects/orm.html
