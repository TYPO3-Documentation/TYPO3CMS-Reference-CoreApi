.. include:: ../../Includes.txt

.. _cgl-database-access:

Accessing the database
^^^^^^^^^^^^^^^^^^^^^^

The TYPO3 database should always be accessed using the QueryBuilder of doctrine.
The :code:`TYPO3\CMS\Core\Database\ConnectionPool` class can be used to create
a :code:`\TYPO3\CMS\Core\Database\Query\QueryBuilder` instance::

   $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tablename');

See the :ref:`Database Access API documentation <database>` for more details.
