:navigation-title: Persistence and ORM

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Persistence
..  _extbase-concepts-persistence:

=====================================
Persistence and the Extbase ORM
=====================================

Extbase includes an Object-Relational Mapper (ORM). The ORM's job is to
translate between the relational world of database tables and the
object-oriented world of PHP classes — so you work with :php:`Event` objects
rather than raw database rows, and Extbase handles the SQL.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-concepts-persistence-orm:

What the ORM does for you
=========================

Without an ORM, reading a record means writing a query, iterating over result
rows, and manually constructing PHP objects. Writing a record means constructing
an INSERT or UPDATE statement yourself. With the Extbase ORM:

*   Reading: you call :php:`$this->eventRepository->findAll()` and receive a
    collection of fully populated :php:`Event` objects.
*   Writing: you call :php:`$this->eventRepository->add($event)` and the ORM
    generates the INSERT statement.
*   Updating: you modify a property on the object and call
    :php:`$this->eventRepository->update($event)`.
*   Deleting: you call :php:`$this->eventRepository->remove($event)`.

A controller action that creates and stores a new event looks like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/EventController.php

    use MyVendor\MyExtension\Domain\Model\Event;
    use MyVendor\MyExtension\Domain\Repository\EventRepository;
    use Psr\Http\Message\ResponseInterface;

    public function createAction(Event $event): ResponseInterface
    {
        $this->eventRepository->add($event);
        return $this->redirect('list');
    }

No SQL, no INSERT, no result-set iteration. The ORM handles the mapping.

The ORM also handles relations. If an :php:`Event` has many :php:`Speaker`
objects stored in an :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`,
Extbase loads those related objects automatically when you access the property
— without you writing any JOIN.

This convenience comes with a trade-off: the ORM is optimised for working with
individual domain objects, not for bulk operations or complex aggregate queries.
When you need those, dropping down to DBAL directly is the right choice. That
is not a failure — it is the intended design.


..  _extbase-concepts-persistence-mapping:

How models map to the database
================================

Extbase derives the database table name from the model class name by convention:

..  code-block:: text

    Vendor\MyExtension\Domain\Model\Event
    → tx_myextension_domain_model_event

Property names map to column names by converting camelCase to snake_case:

..  code-block:: text

    $eventDate     →  event_date
    $speakerCount  →  speaker_count

These conventions work automatically. When the defaults do not fit — for example
when mapping to an existing table with its own naming — you can override them in
:file:`Configuration/Extbase/Persistence/Classes.php`.


..  _extbase-concepts-persistence-repository:

The repository as the only door to the database
================================================

Controllers never query the database directly. Every database interaction goes
through a repository. This is a deliberate constraint: it keeps persistence
logic in one place and keeps controllers thin.

A repository class extends :php:`\TYPO3\CMS\Extbase\Persistence\Repository` and
is named after its model — :php:`EventRepository` for :php:`Event`. The base
class provides :php:`findAll()`, :php:`findByUid()`,
:php:`findBy(array $criteria)`, and :php:`findOneBy(array $criteria)` without
any additional code. Custom queries are added as methods on the repository.

Repositories are singletons — one instance per request, shared across all
controllers that inject them.


..  _extbase-concepts-persistence-storagepid:

The storagePid: where Extbase looks for records
================================================

This is the single most common source of confusion in Extbase: a repository
returns no results even though the records exist in the database.

The cause is almost always the **storagePid**.

Extbase does not query all records in a table by default. It restricts queries
to records stored on a specific TYPO3 page — the *storage page* (or
*storagePid*). This mirrors how TYPO3 editors organise records: they create a
sysfolder, store domain records there, and point the plugin at that folder.

If the storagePid is not configured, or points at the wrong page, the
repository returns an empty result — silently.

The storagePid is configured in TypoScript:

..  code-block:: typoscript

    plugin.tx_myextension.persistence.storagePid = 42

Or per plugin instance:

..  code-block:: typoscript

    plugin.tx_myextension_eventlist.persistence.storagePid = 42

Editors can also set it per plugin content element via the
:guilabel:`Record Storage Page` field in the plugin's properties.

..  tip::

    If your repository returns nothing and the records exist in the database,
    check the storagePid first. Enable TYPO3's query logging or use the Extbase
    query debugger to see the exact SQL being executed and which page restriction
    is applied.

The full storagePid resolution order and how to override it in PHP are covered
in :ref:`extbase-persistence-queries`.


..  _extbase-concepts-persistence-lifecycle:

Extbase object lifecycle
========================

Extbase tracks the state of every domain object it loads. At the end of a
request the persistence manager flushes automatically, comparing each object's
current state against its original state and writing only the differences. You
do not need to call a "save" method on objects you retrieved and modified — the
ORM detects the change.

Objects you create with :php:`new` are not tracked until you pass them to a
repository with :php:`add()`. Objects you pass to :php:`remove()` are deleted
at flush time.

..  seealso::

    :ref:`extbase-domain-model` — defining models and their properties.

    :ref:`extbase-domain-repository` — writing custom repository queries.

    :ref:`extbase-persistence-queries` — the full query API, storagePid
    deep-dive, and when to use DBAL instead.
