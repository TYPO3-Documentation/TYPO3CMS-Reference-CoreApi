.. include:: ../../../Includes.txt

.. _database-class-overview:

==============
Class Overview
==============

Doctrine provides a set of `php` objects to represent, create and handle SQL queries and
their results. The basic class structure was slightly enriched by TYPO3 to add CMS
specific features. Extension authors will typically interact with these classes and objects:

Connection
   :php:`TYPO3\CMS\Core\Database\Connection`: :ref:`Object representing a specific connection <database-connection>`
   to one connected database. Provides "shortcut" methods for simple standard queries like `SELECT` or `UPDATE`.
   An instance of the :ref:`QueryBuilder <database-query-builder>` can be retrieved to build more complex queries.

ConnectionPool
   :php:`TYPO3\CMS\Core\Database\ConnectionPool`: :ref:`Main entry point <database-connection-pool>`
   for extensions to retrieve a specific connection a query should be executed on. Typically
   used to return a :ref:`Connection <database-connection>` or a
   :ref:`QueryBuilder <database-query-builder>` object.

ExpressionBuilder
   :php:`TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder`: :ref:`Object to model complex
   expressions <database-expression-builder>`. Mainly used for `WHERE` and `JOIN` conditions.

QueryBuilder
   :php:`TYPO3\CMS\Core\Database\Query\QueryBuilder`: :ref:`Object to create all sort of complex
   queries <database-query-builder>` executed on a specific connection. Provides the main `CRUD` methods for
   `select()`, `delete()` and friends.

QueryHelper
   :php:`TYPO3\CMS\Core\Database\Query\QueryHelper`: :ref:`Set of static helper methods <database-query-helper>`
   that can simplify the transition from old `TYPO3_DB` based code to the doctrine base API.

Restriction ...
   :php:`TYPO3\CMS\Core\Database\Query\Restriction\...`: :ref:`Set of classes that add expressions
   <database-restriction-builder>` like "deleted=0" to a query based on `TCA` settings of a table.
   This automatically adds TYPO3 specific restrictions like starttime and endtime, as well as deleted
   and hidden flags. Further restrictions for language overlays and workspaces are available. This
   documentation refers to these classes as the `RestrictionBuilder`.

Statement
   :php:`Doctrine\DBAL\Driver\Statement`: :ref:`Result object <database-statement>` retrieved if a `SELECT`
   or `COUNT` query has been executed. Single rows are returned as array by calling `->fetch()` until
   the method returns `false`.

