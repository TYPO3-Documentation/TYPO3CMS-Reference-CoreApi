.. include:: /Includes.rst.txt
.. index:: File; EXT:{extkey}/ext_tables_static+adt.sql
.. _ext_tables_static+adt.sql:

=======================================
:file:`ext_tables_static+adt.sql`
=======================================

Static SQL tables and their data.

If the extension requires static data you can dump it into an SQL file
by this name. Example for dumping MySQL/MariaDB data from shell (executed in the
extension's root directory):

.. code-block:: shell

   mysqldump --user=[user] --password [database name] \
             [tablename] > ./ext_tables_static+adt.sql

Note that only :sql:`INSERT INTO` statements are allowed. If the contents of the
SQL file change, the table is truncated and the new data is inserted.

The table structure of static tables needs to be in the
:file:`ext_tables.sql` file as well - otherwise an installed static
table will be reported as being in excess in the Install Tool.

.. warning::

   Static data is not meant to be extended by other extensions. On
   re-import all extended fields and data is lost.
