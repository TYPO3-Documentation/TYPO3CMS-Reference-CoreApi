.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Database access
^^^^^^^^^^^^^^^

The TYPO3 database contains all data of backend and frontend users and
therefore special care must be taken not to grant unauthorized access.


Secure passwords, usernames and minimum access privileges
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""

The MySQL privilege system authenticates a (database-)user who
connects from the TYPO3 host (which is possibly on the same machine)
and associates that user with privileges on a database. These
privileges are for example: SELECT, INSERT, UPDATE, DELETE, etc.

When creating this user, follow the guidelines for secure passwords in
this document. The name of the user should definitely not be "root",
"admin", "typo3", etc. You should create a database specific user with
limited privileges for accessing the database from TYPO3. Usually this
user does not require access to any other databases and the database
of your TYPO3 instance should usually only have one associated
database user.

MySQL and other database systems provide privileges that apply at
different levels of operation. It depends on your individual system
and setup which privileges the database user needs (SELECT, INSERT,
UPDATEand some more are essential of course) but privileges like LOCK
TABLES, FILE, PROCESS, CREATE USER, RELOAD, SHUTDOWN, etc. are in the
context of administrative privileges and not required in most cases.

See the documentation of your database system on how to set up
database users and access privileges (e.g. chapter 5.4 and chapter
12.7.1 of the MySQL documentation).


Disallow external access
""""""""""""""""""""""""

The database server should only be reachable from the server that your
TYPO3 installation is running on. Make sure to disable any access from
outside of your server or network (settings in firewall rules) and/or
do not bind the database server to a network interface.

If you are using MySQL, read the chapter "Server Options" in the
manual and check for the "skip-networking" and "bind-address" options
in particular.


Database administration tools
"""""""""""""""""""""""""""""

phpMyAdmin and similar tools intend to allow the administration of
MySQL database servers over the Web. Under certain circumstances, it
might be required to access the database "directly", during a project
development phase for example. Tools like "phpMyAdmin" (also available
as a TYPO3 extension by the way) cause extra effort for ongoing
maintenance (regular updates of these tools are required to ensure a
minimum level of security). If they are not avoidable by any chance,
the standalone version with an additional web server's access
authentication (e.g. Apache's ".htaccess" mechanism) should be used at
least.

However, due to the fact that a properly configured TYPO3 system does
not require direct access to the database for editors or TYPO3
integrators, those applications should not be used on a production
site at all.

