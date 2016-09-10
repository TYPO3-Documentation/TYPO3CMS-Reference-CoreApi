.. include:: ../../Includes.txt

.. _database-class-overview:

Class overview
--------------

Doctrine provides a set of `php` objects to represent, create and handle SQL queries and
their results. The basic class structure was slightly enriched by TYPO3 to add CMS
specific features. Extension authors will typically interact with these classes and objects:

* `TYPO3\CMS\Core\Database\ConnectionPool`: Main entry point for extensions to retrieve
  a specific connection a query should be executed on.

* `TYPO3\CMS\Core\Database\Connection`: Object representing a specific connection to one
  connected database. Provides "shortcut" methods for simple standard queries
  like select() or update(). An instance of the QueryBuilder can be retrieved to build
  more complex queries.

* `TYPO3\CMS\Core\Database\Query\QueryBuilder`: Object to create all sort of complex
  queries executed on a specific connection. Provides the main `CRUD` methods for
  select(), delete() and friends.

* `TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder`: Object to model complex
  expressions. Mainly used for "WHERE" and "JOIN" restrictions.

* `TYPO3\CMS\Core\Database\Query\Restriction\...`: Set of classes that add expressions
  like "deleted=0" to a query based on `TCA` settings of a table. This automatically adds
  TYPO3 specific restrictions like starttime and endtime, as well as deleted and hidden flags.
  Further restrictions for language overlays and workspaces are available.

* `Doctrine\DBAL\Driver\Statement`: Result object retrieved if a select query has been
  executed. Single rows are returned as array by calling `->fetch()` until the method
  returns false.
