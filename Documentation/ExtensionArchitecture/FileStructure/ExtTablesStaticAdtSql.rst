.. include:: /Includes.rst.txt
.. index:: File; EXT:{extkey}/ext_tables_static+adt.sql
.. _ext_tables_static+adt.sql:

=======================================
:file:`ext_tables_static+adt.sql`
=======================================

Static SQL tables and their data.

If the extension requires static data you can dump it into an SQL file
by this name. Example for dumping mysql data from bash (being in the
extension directory):

.. code-block:: shell

   mysqldump --add-drop-table \
               --password=[password] [database name] \
               [tablename]  > ./ext_tables_static+adt.sql

:code:`--add-drop-table` will make sure to include a DROP TABLE
statement so any data is inserted in a fresh table.

You can also drop the table content using the Extension Manager in the backend.

.. note::

   The table structure of static tables needs to be in the
   :file:`ext_tables.sql` file as well - otherwise an installed static
   table will be reported as being in excess in the Install Tool.

.. warning::

   Static data is not meant to be extended by other extensions. On
   re-import all extended fields and data is lost due to `DROP TABLE`
   statements.
