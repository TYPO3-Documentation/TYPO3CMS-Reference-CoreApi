:navigation-title: Persistence and ORM

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Persistence
..  _extbase-concepts-persistence:

=====================================
Persistence and the Extbase ORM
=====================================

Extbase includes an Object-Relational Mapper (ORM). The ORM's job is to
translate between the relational world of database tables and the
object-oriented world of PHP classes — so you work with :php:`Conference` objects
rather than raw database rows, and Extbase handles the SQL.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-concepts-persistence-orm:

What the ORM does for you
=========================

Without an ORM, reading a record means writing a query, iterating over result
rows, and manually constructing PHP objects. Writing a record means constructing
an :sql:`INSERT` or :sql:`UPDATE` statement yourself. With the Extbase ORM:

*   Reading: you call :php:`$this->conferenceRepository->findAll()` and receive a
    collection of fully populated :php:`Conference` objects.
*   Writing: you call :php:`$this->conferenceRepository->add($conference)` and the ORM
    generates the INSERT statement.
*   Updating: you modify a property on the object and call
    :php:`$this->conferenceRepository->update($conference)`.
*   Deleting: you call :php:`$this->conferenceRepository->remove($conference)`.

A controller action that creates and stores a new conference looks like this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Model\Conference;
    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}

        public function createAction(Conference $conference): ResponseInterface
        {
            $this->conferenceRepository->add($conference);
            return $this->redirect('list');
        }
    }

No SQL, no INSERT, no result-set iteration. The ORM handles the mapping.

The ORM also handles relations. If a :php:`Conference` has many :php:`Speaker`
objects stored in an :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`,
Extbase loads those related objects automatically when you access the property
— without you writing any JOIN.

This convenience comes with a trade-off: the ORM is optimised for working with
individual domain objects, not for bulk operations or complex aggregate queries.
When you need those, dropping down to :abbr:`DBAL (Database Abstraction Layer)`
directly is the right choice. That is not a failure — it is the intended design.
See :ref:`extbase-domain-repository-dbal` for how to do this from within a
repository.


..  _extbase-concepts-persistence-mapping:

How models map to the database
================================

Extbase derives the database table name from the model class name by convention:

..  code-block:: text

    Vendor\MyExtension\Domain\Model\Conference
    → tx_myextension_domain_model_conference

Property names map to column names by converting camelCase to snake_case:

..  code-block:: text

    $conferenceDate     →  conference_date
    $speakerCount  →  speaker_count

These conventions work automatically. When the defaults do not fit — for example
when mapping to an existing table with its own naming — you can override them in
:file:`Configuration/Extbase/Persistence/Classes.php`.


..  _extbase-concepts-persistence-repository:

The repository as the only door to the database
================================================

Controllers should not query the database directly. Every database interaction goes
through a repository. This is a deliberate constraint: it keeps persistence
logic in one place and keeps controllers thin.

A repository class extends :php:`\TYPO3\CMS\Extbase\Persistence\Repository` and
is named after its model — :php:`ConferenceRepository` for :php:`Conference`. The base
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
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension.persistence.storagePid = 42

Or per plugin instance:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension_eventlist.persistence.storagePid = 42

Editors can also set it per plugin content element via the
:guilabel:`Record Storage Page` field in the plugin's properties.

..  tip::

    If your repository returns nothing and the records exist in the database,
    check the storagePid first. Enable TYPO3's query logging or use the Extbase
    query debugger to see the exact SQL being executed and which page restriction
    is applied.

To disable the storagePid restriction entirely — for example in a backend
context or when querying across all pages — set it to :typoscript:`0`:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension.persistence.storagePid = 0

Or override it in PHP inside a repository method:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    $query = $this->createQuery();
    $query->getQuerySettings()->setRespectStoragePage(false);

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

In most actions the automatic flush at the end of the request is sufficient.
Two cases require an earlier flush:

*   **Before a redirect** — if you call :php:`$this->redirect()` after
    :php:`add()`, the redirect fires before the automatic flush, so the new
    object is never written. Call
    :php:`$this->persistenceManager->persistAll()` before the redirect.
*   **When you need the new UID** — a freshly created object has no UID until
    it is persisted. Call :php:`persistAll()` and then read
    :php:`$object->getUid()`.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Model\Conference;
    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
    use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
            protected readonly PersistenceManagerInterface $persistenceManager,
        ) {}

        public function createAction(Conference $conference): ResponseInterface
        {
            $this->conferenceRepository->add($conference);
            $this->persistenceManager->persistAll();
            $uid = $conference->getUid();
            return $this->redirect('show', null, null, ['conference' => $uid]);
        }
    }

..  seealso::

    `Extbase domain model <https://docs.typo3.org/permalink/extbase-domain-model>`_ — defining models and their properties.

    `Extbase repository <https://docs.typo3.org/permalink/extbase-domain-repository>`_ — writing custom repository queries.

    `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — the full query API, storagePid
    deep-dive, and when to use DBAL instead.
