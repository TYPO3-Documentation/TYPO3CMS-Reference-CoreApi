:navigation-title: Upgrade

..  include:: /Includes.rst.txt
..  index:: Database; Upgrade
..  _database-upgrade:

===================================
Upgrade table and field definitions
===================================

Each extension in TYPO3 can provide the :file:`ext_tables.sql` file that defines
which tables and fields the extension needs. Gathering all
:file:`ext_tables.sql` files thus defines the complete set of tables, fields and
indexes of a TYPO3 instance to unfold its full functionality. The
:guilabel:`Analyze Database Structure` section in the
:guilabel:`Admin Tools > Maintenance` backend module can compare the defined set
with the current active database schema and shows options to align these two by
adding fields, removing fields and so on.

When you upgrade to newer versions of TYPO3 or upgrade an extension, the data
definition of tables and fields may have changed. The database structure
analyzer detects such changes.

When you install a new extension, any change to the database is performed
automatically. When upgrading to a new major version of TYPO3, you should
normally go through the upgrade wizard, whose first step is to perform all
necessary database changes:

..  include:: /Images/AutomaticScreenshots/AdminTools/DatabaseUpgradeWizard.rst.txt

If you want to perform minor updates, update extensions or generally check the
functionality of your system, you can go to
:guilabel:`Admin Tools > Maintenance > Analyze Database Structure`:

.. include:: /Images/AutomaticScreenshots/AdminTools/AnalyzeDatabase.rst.txt

This tool collects the information from all :file:`ext_tables.sql` files of all
active extensions and compares them with the current database structure. Then it
proposes to perform the necessary changes, grouped by type:

-   creating new tables
-   adding new fields to existing tables
-   altering existing fields
-   dropping unused tables and fields

You can choose which updates you want to perform. You can even decide not to
create new fields and tables, although that will very likely break your
installation.

..  include:: /Images/AutomaticScreenshots/AdminTools/DatabaseAnalyzer.rst.txt

..  seealso::
    For more information about the process of upgrading TYPO3, see chapter
    :ref:`Upgrades <upgrading>`.


..  index::
    File; EXT:{extkey}/ext_tables.sql
    Database; CREATE TABLE
..  _database-exttables-sql:

The ext\_tables.sql files
=========================

As mentioned above, all data definition statements are stored in files named
:file:`ext_tables.sql`, which may exist in any extension.

The peculiarity is that these files may not always contain a complete and valid
SQL data definition. For example, the "dashboard" system extension defines a new
table for storing dashboards:

..  code-block:: sql
    :caption: EXT:dashboard/ext_tables.sql

    CREATE TABLE be_dashboards (
        identifier varchar(120) DEFAULT '' NOT NULL,
        title varchar(120) DEFAULT '' NOT NULL,
        widgets text
    );

This is a complete and valid SQL data definition. However, the community
extension "news" extends the :sql:`tt_content` table with additional fields. It
also provides these changes in the form of a SQL :sql:`CREATE TABLE` statement:

..  code-block:: sql
    :caption: EXT:news/ext_tables.sql

    CREATE TABLE tt_content (
        tx_news_related_news int(11) DEFAULT '0' NOT NULL,
        KEY index_newscontent (tx_news_related_news)
    );

The classes which take care of assembling the complete SQL data definition will
compile all the :sql:`CREATE TABLE` statements for a given table and turn them
into a single :sql:`CREATE TABLE` statement. If the table already exists,
missing fields are isolated and :sql:`ALTER TABLE` statements are proposed
instead.

This means that as an extension developer you should always only have
:sql:`CREATE TABLE` statements in your :file:`ext_tables.sql` files, the system
will handle them as needed.
