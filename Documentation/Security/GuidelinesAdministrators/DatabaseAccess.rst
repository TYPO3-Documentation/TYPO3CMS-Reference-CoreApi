.. include:: /Includes.rst.txt
.. index:: pair: Security guidelines; Database access
.. _security-database-access:

===============
Database access
===============

The TYPO3 database contains all data of backend and frontend users and
therefore special care must be taken not to grant unauthorized access.

.. index::
    Database; Secure passwords
    Database; Access privileges

Secure passwords and minimum access privileges with MySQL
=========================================================

If using MySQL, the privilege system authenticates a (database-)user who
connects from the TYPO3 host (which is possibly on the same machine)
and associates that user with privileges on a database. These
privileges are for example: SELECT, INSERT, UPDATE, DELETE, etc.

When creating this user, follow the guidelines for :ref:`secure passwords
<security-secure-passwords>`. The name of the user should definitely not be `root`,
`admin`, `typo3`, etc. You should create a database specific user with
limited privileges for accessing this database from TYPO3. Usually this
user does not require access to any other databases and the database
of your TYPO3 instance should usually only have one associated
database user.

MySQL and other database systems provide privileges that apply at
different levels of operation. It depends on your individual system
and setup which privileges the database user needs (SELECT, INSERT,
UPDATE and some more are essential of course) but privileges like LOCK
TABLES, FILE, PROCESS, CREATE USER, RELOAD, SHUTDOWN, etc. are in the
context of administrative privileges and not required in most cases.

See the documentation of your database system on how to set up
database users and access privileges.

.. index::
    Database; SQLite
    pair: Security guidelines; SQLite

Database not within web document root with SQLite
=================================================

If using SQLite as underlying database, a database is stored in a single
file. In TYPO3, its default location is the :ref:`var/sqlite <Environment-var-path>` path
of the instance which is derived from environment variable :php:`TYPO3_PATH_APP`. If that
variable is **not** set which is often the case in not Composer based instances, **the database
file will end up in the web server accessible document root directory :file:`typo3conf/`**!
In such a setup it is important to configure Web servers to not deliver :file:`.sqlite` files.


Disallow external access
========================

The database server should only be reachable from the server that your
TYPO3 installation is running on. Make sure to disable any access from
outside of your server or network (settings in firewall rules) and/or
do not bind the database server to a network interface.

If you are using MySQL, read the chapter
`Server Options <https://dev.mysql.com/doc/refman/8.0/en/server-option-variable-reference.html>`_
in the manual and check for the "skip-networking" and "bind-address" options
in particular.

.. index::
    pair: Security guidelines; Database administration tools
    pair: Security guidelines; phpMyAdmin

Database administration tools
=============================

`phpMyAdmin` and similar tools intend to allow the administration of
MySQL database servers over the Web. Under certain circumstances, it
might be required to access the database "directly", during a project
development phase for example. Tools like `phpMyAdmin` (also available
as a TYPO3 extension by the way) cause extra effort for ongoing
maintenance (regular updates of these tools are required to ensure a
minimum level of security). If they are not avoidable by any chance,
the standalone version with an additional web server's access
authentication (e.g. Apache's :file:`.htaccess` mechanism) should be used at
least.

However, due to the fact that a properly configured TYPO3 system does
not require direct access to the database for editors or TYPO3
integrators, those applications should not be used on a production
site at all.
