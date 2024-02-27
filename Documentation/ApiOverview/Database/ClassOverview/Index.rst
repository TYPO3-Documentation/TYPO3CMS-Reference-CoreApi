..  include:: /Includes.rst.txt

..  _database-class-overview:

==============
Class overview
==============

Doctrine DBAL provides a set of PHP objects to represent, create and handle SQL
queries and their results. The basic class structure has been slightly enriched
by TYPO3 to add CMS-specific features. Extension authors will usually interact
with these classes and objects:

:php:`TYPO3\CMS\Core\Database\Connection`
    This object represents a specific :ref:`connection <database-connection>` to
    one connected database. It provides "shortcut" methods for simple standard
    queries like :sql:`SELECT` or :sql:`UPDATE`. To create more complex queries,
    an instance of the :ref:`QueryBuilder <database-query-builder>` can be
    retrieved.

:php:`TYPO3\CMS\Core\Database\ConnectionPool`
    The :ref:`ConnectionPool <database-connection-pool>` is the main entry point
    for extensions to retrieve a specific connection over which to execute a
    query. Usually it is used to return a :ref:`Connection
    <database-connection>` or a :ref:`QueryBuilder <database-query-builder>`
    object.

:php:`TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder`
    The :ref:`ExpressionBuilder <database-expression-builder>` object is used to
    model complex expressions. It is mainly used for :sql:`WHERE` and
    :sql:`JOIN` conditions.

:php:`TYPO3\CMS\Core\Database\Query\QueryBuilder`
    With the help of the :ref:`QueryBuilder <database-query-builder>` one can
    create all sort of complex queries executed on a specific connection. It
    provides the main :abbr:`CRUD (Create, read, update, delete)` methods for
    :sql:`select()`, :sql:`delete()` and friends.

:php:`TYPO3\CMS\Core\Database\Query\Restriction\...`
    :ref:`Restrictions <database-restriction-builder>` are a set of classes that
    add expressions like :sql:`deleted=0` to a query, based on the
    :ref:`TCA settings of a table <t3tca:ctrl>`. They automatically adds
    TYPO3-specific restrictions like start time and end time, as well as deleted
    and hidden flags. Further restrictions for language overlays and workspaces
    are available. In this documentation, these classes are referred as
    :php:`RestrictionBuilder`.

:php:`Doctrine\DBAL\Driver\Statement`
    This :ref:`result object <database-statement>` is returned when a
    :sql:`SELECT` or :sql:`COUNT` query was executed. Single rows are returned
    as an array by calling :php:`->fetchAssociative()` until the method
    returns :php:`false`.
