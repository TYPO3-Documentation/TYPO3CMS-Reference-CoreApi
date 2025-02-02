..  include:: /Includes.rst.txt
..  index:: File; EXT:{extkey}/ext_tables_static+adt.sql
..  _ext_tables_static+adt.sql:

===========================
`ext_tables_static+adt.sql`
===========================

..  typo3:file:: ext_tables_static+adt.sql
    :scope: extension
    :regex: /^.*ext\_tables\_static\+adt\.sql$/
    :shortDescription: Holds static SQL tables and their data.

    Holds static SQL tables and their data.

    If the extension requires static data you can dump it into an SQL file
    by this name. Example for dumping MySQL/MariaDB data from shell (executed in the
    extension's root directory):

..  code-block:: shell

    mysqldump --user=[user] --password [database name] \
              [tablename] > ./ext_tables_static+adt.sql

Note that only :sql:`INSERT INTO` statements are allowed. The file is
interpreted whenever the corresponding extension's setup routines get called:
Upon first time installation, command task execution of
:bash:`bin/typo3 extension:setup` or via the :guilabel:`Admin Tools > Extensions`
interface and the :guilabel:`Reload extension data` action. The static data is
then only re-evaluated, if the file has different contents than on the last
execution. In that case, the table is truncated and the new data imported.

The table structure of static tables must be declared in the
:file:`ext_tables.sql` file, otherwise data cannot be added to a static table.

..  warning::

    Static data is not meant to be extended by other extensions. On
    re-import all extended fields and data is lost.
