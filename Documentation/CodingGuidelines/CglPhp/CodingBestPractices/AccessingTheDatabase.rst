.. include:: /Includes.rst.txt
.. index:: pair: Coding guidelines; Database
.. _cgl-database-access:

======================
Accessing the Database
======================

The TYPO3 database should always be accessed using the QueryBuilder of doctrine.
The :php:`TYPO3\CMS\Core\Database\ConnectionPool` class can be used to create
a :php:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` instance::

   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tablename');

See the :ref:`Database Access API documentation <database>` for more details.
