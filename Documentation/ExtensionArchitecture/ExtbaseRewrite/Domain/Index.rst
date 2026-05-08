:navigation-title: Domain

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Domain
..  _extbase-domain-overview:

=======================
Domain layer in Extbase
=======================

The domain layer is where your extension's data lives. It consists of two
things: **models**, which are PHP classes that represent your data, and
**repositories**, which are the only entry point for reading and writing that
data to the database.

A model describes what an object looks like — its properties, their types,
and how they relate to other objects. A repository knows how to find and
persist those objects. Controllers and views never touch the database directly;
they always go through a repository.

Value objects — objects defined by their value rather than their identity —
are also part of the domain layer. In TYPO3 v14, value objects are implemented
as plain PHP classes rather than by extending an Extbase base class.
Their usage is covered in the :ref:`model page <extbase-domain-model-value-objects>`.

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Model <extbase-domain-model>`

        How to define domain objects that map to database records.
        Covers :php:`AbstractEntity`, property types, extbase related PHP attributes,
        relations, enums and table mapping.

    ..  card:: :ref:`Repository <extbase-domain-repository>`

        How to find and persist domain objects. Covers built-in find
        methods, default ordering and custom queries.
        StoragePid configuration gets special attention.

..  toctree::
    :titlesonly:
    :hidden:

    Model
    Repository
