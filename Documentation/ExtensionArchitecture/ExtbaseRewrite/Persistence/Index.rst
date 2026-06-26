:navigation-title: Persistence

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Persistence
..  _extbase-persistence-overview:

============================
Persistence layer in Extbase
============================

The persistence layer is where Extbase turns database rows into domain objects
and writes your changes. Once your models and repositories exist, this
chapter is about *using* them well: querying for the right records, setting
which pages and languages a query covers, loading all related objects, and knowing
the performance trade-offs before they bite.

This chapter assumes you already have a model and a repository. If you do not,
start with the domain chapter:

..  seealso::

    *   `Persistence and the Extbase ORM <https://docs.typo3.org/permalink/extbase-concepts-persistence>`_ — the mental model: what the ORM does, how objects map to tables, the object lifecycle.

    *   `Extbase domain model <https://docs.typo3.org/permalink/extbase-domain-model>`_ — defining models, properties and relation declarations.

    *   `Extbase repository <https://docs.typo3.org/permalink/extbase-domain-repository>`_ — the repository, its find methods and the constraint API.

The two pages in this chapter cover:

:ref:`extbase-persistence-queries`
    Everything around a query: the **storagePid** resolution chain (the most
    common reason a query does not return what you expect), query settings
    (language, enable fields, deleted records), limiting, ordering and
    pagination, when changes reach the database with :php:`persistAll()`, and how
    to debug a query by inspecting its SQL.

:ref:`extbase-persistence-relations`
    The two relation **shapes** — a relation to one object and a relation to many
    — and how each is stored, how Extbase loads related objects, and the **lazy
    loading versus N+1 query** trade-off that decides the performance of a list
    view with relations.

..  toctree::
    :titlesonly:
    :hidden:

    Queries
    Relations
