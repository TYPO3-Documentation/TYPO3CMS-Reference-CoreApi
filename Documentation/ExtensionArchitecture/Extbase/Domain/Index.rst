:navigation-title: Domain

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Domain
..  _extbase-domain-overview:
..  _extbase-domain:
..  _extbase-domain-subfolders:

=======================
Domain layer in Extbase
=======================

The domain layer is where your extension's data lives. It consists of two
things: **models**, which are PHP classes that represent your data, and
**repositories**, which are the only entry point for reading and writing that
data to the database.

A model describes what an object looks like — its properties, their types,
and how they relate to other objects. A repository knows how to find and
persist those objects. Controllers and views should never touch the database directly,
but refer such tasks to a repository.

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
        Covers :php-short:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`, property types, extbase related PHP attributes,
        relations, enums and table mapping.

    ..  card:: :ref:`Repository <extbase-domain-repository>`

        How to find and persist domain objects. Covers built-in find
        methods, default ordering and custom queries.
        StoragePid configuration gets special attention.

    ..  card:: :ref:`File uploads <extbase-domain-fileupload>`

        Reading :abbr:`FAL (File Abstraction Layer)` file references from a
        domain model, handling uploads with :php:`#[FileUpload]`, validation and
        deletion.

    ..  card:: :ref:`Data transfer objects <extbase-domain-dto>`

        Non-persisted objects that carry data between the business logic and the
        view: validation, converting to a model, session storage and demand
        objects.

    ..  card:: :ref:`Property types <extbase-domain-property-types>`

        Which PHP property types map to which TCA field and database column:
        primitives, :php:`\DateTime`, :php:`\Country`, enumerations and union
        types.

..  toctree::
    :titlesonly:
    :hidden:

    Model
    Repository
    FileUpload
    Dto
    PropertyTypes
