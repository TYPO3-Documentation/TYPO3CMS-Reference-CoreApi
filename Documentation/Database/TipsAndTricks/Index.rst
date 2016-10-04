.. include:: ../../Includes.txt

.. _database-tips-and-tricks:

Various tips and tricks
-----------------------

* `INSERT`, `UPDATE` and `DELETE` statements are often easier to read and write
  using the `Connection` object instead of the `QueryBuilder`.

* `SELECT DISTINCT aField` is not supported but can be substituted with a `->groupBy('aField')`.

* `getSQL()` and `execute()` can be used after each other during development to simplify debugging:
.. code-block:: php

    $queryBuilder
        ->select('uid')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('bodytext', $queryBuilder->createNamedParameter('klaus'))
        );
    debug($queryBuilder->getSql());
    $statement = $queryBuilder->execute();

* In contrast to the old API based on `$GLOBALS['TYPO3_DB']`, `doctrine-dbal` will throw exceptions
  if something goes wrong when calling `execute()`. The exception type is a `\Doctrine\DBAL\DBALException`
  which can be caught and transferred to a better error message if the application has to expect
  query errors. Note this is not good habit and often indicates an architectural flaw of the application
  at a different layer.

* `count()` query types using the `QueryBuilder` typically call `->fetchColumn(0)` to receive the count
  value. The `count()` method of `Connection` object does that automatically and returns the count value
  result directly.