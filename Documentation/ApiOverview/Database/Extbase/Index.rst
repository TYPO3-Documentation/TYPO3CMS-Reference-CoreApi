:navigation-title: Extbase persistence

..  include:: /Includes.rst.txt
.. _database-extbase:

=============================================
Extbase persistence – models and the database
=============================================

Extbase provides its own way to persist and retrieve data using **models** and
**repositories**, which are built on top of TYPO3's database abstraction layer.

..  seealso::

    -   `Extbase models <https://docs.typo3.org/permalink/t3coreapi:extbase-model>`_
    -   `Repository pattern in Extbase <https://docs.typo3.org/permalink/t3coreapi:extbase-repository>`_
    -   `Manual mapping for arbitrary tables <https://docs.typo3.org/permalink/t3coreapi:extbase-manual-mapping>`_

Repositories in Extbase usually define custom `find*()` methods and rely on
:php:`\TYPO3\CMS\Extbase\Persistence\Generic\Query` to perform queries on models.

While **Extbase persistence** is the standard way to work with data in Extbase,
you can also use the **DBAL QueryBuilder** directly within an Extbase context when:

-   You need better performance on large datasets.
-   You are performing complex queries (aggregates like :sql:`SUM`, :sql:`AVG`,
    ...).

..  note::

    Extbase queries and DBAL queries are **not interchangeable**. Extbase uses its
    own persistence layer with different concepts and behaviors. Use each
    approach where it fits best — and avoid mixing them in the same method or query logic.
