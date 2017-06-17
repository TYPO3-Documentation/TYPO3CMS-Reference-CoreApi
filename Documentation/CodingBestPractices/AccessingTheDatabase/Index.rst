.. include:: ../../Includes.txt


.. _database-access:

Accessing the database
^^^^^^^^^^^^^^^^^^^^^^

TYPO3 version 8 LTS
-------------------

The TYPO3 database should always be accessed using the QueryBuilder of Doctrine.
The :code:`TYPO3\CMS\Core\Database\ConnectionPool` class can be used to create
a :code:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` instance::

   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tablename');


For TYPO3 versions before 8 LTS
-------------------------------

The TYPO3 database should always be accessed through the use of
:code:`$GLOBALS['TYPO3_DB']`. This is the instance of the
:code:`DatabaseConnection` class from
:code:`typo3/sysext/core/Classes/Database/DatabaseConnection.php`.

The same rule applies for accessing non-TYPO3 databases: they should
be accessed by using a different instance of the same class. Failing
this condition may corrupt the TYPO3 database or prevent access to the
TYPO3 database for the rest of the script.

