:navigation-title: Repository

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Repository
..  _extbase-domain-repository:

==================
Extbase repository
==================

A repository is the only entry point to the database for a given model type.
Controllers and services ask a repository for objects — they should not query the
database directly. This keeps persistence logic in one place and makes
controllers easy to test.

Every Extbase extension has one repository per model. The repository class
often does not need a single line of custom code.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-domain-repository-basics:

The minimal repository
======================

A repository extends :php:`\TYPO3\CMS\Extbase\Persistence\Repository`. The
class name must follow the convention: the model class
:php:`Domain\Model\Event` maps to :php:`Domain\Repository\EventRepository`.
Extbase resolves this automatically.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

    declare(strict_types=1);

    namespace MyVendor\MyExtension\Domain\Repository;

    use TYPO3\CMS\Extbase\Persistence\Repository;

    class EventRepository extends Repository {}

That empty class already provides all the standard methods described below.


..  _extbase-domain-repository-find-methods:

Built-in find methods
======================

:php:`Repository` provides these methods out of the box:

..  confval-menu::
    :name: extbase-repository-methods
    :display: table
    :type:
    :default:

    ..  confval:: findAll()
        :name: repo-findAll
        :type: `QueryResultInterface`

        Returns all records from the repository's storage page(s).

    ..  confval:: findByUid(int $uid)
        :name: repo-findByUid
        :type: `object|null`

        Returns the object with the given UID, or :php:`null`.
        Ignores storagePid — always searches across all pages.

    ..  confval:: findByIdentifier(mixed $identifier)
        :name: repo-findByIdentifier
        :type: `object|null`

        Alias for :php:`findByUid()` — the identifier is the UID.

    ..  confval:: findBy(array $criteria, ?array $orderBy, ?int $limit, ?int $offset)
        :name: repo-findBy
        :type: `QueryResultInterface`

        Finds all objects matching the given criteria array.
        Example: :php:`findBy(['published' => true])`.

    ..  confval:: findOneBy(array $criteria, ?array $orderBy)
        :name: repo-findOneBy
        :type: `object|null`

        Returns the first object matching the criteria, or :php:`null`.

    ..  confval:: count(array $criteria)
        :name: repo-count
        :type: `int`

        Returns the number of matching objects without loading them.

    ..  confval:: countAll()
        :name: repo-countAll
        :type: `int`

        Returns the total number of objects in the repository.

..  warning::

    **Magic find methods were removed in TYPO3 v14.**

    Methods like :php:`findByTitle($value)`, :php:`findOneByTitle($value)`,
    and :php:`countByTitle($value)` were deprecated in v12.3 and **removed in
    v14** (Deprecation `#100071
    <https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.3/Deprecation-100071-MagicRepositoryFindByMethods.html>`__).

    Replace them with the explicit array-based signatures:

    +------------------------------+------------------------------------+
    | Old (removed in v14)         | New                                |
    +==============================+====================================+
    | ``findByTitle($value)``      | ``findBy(['title' => $value])``    |
    +------------------------------+------------------------------------+
    | ``findOneByTitle($value)``   | ``findOneBy(['title' => $value])`` |
    +------------------------------+------------------------------------+
    | ``countByTitle($value)``     | ``count(['title' => $value])``     |
    +------------------------------+------------------------------------+

    :php:`findByUid()` and :php:`findByIdentifier()` are **not** affected and
    remain available.


..  _extbase-domain-repository-ordering:

Ordering
========

There are two distinct places to define ordering, and they serve different
purposes.

**Repository-wide default ordering** applies to every query from this
repository — :php:`findAll()`, :php:`findBy()`, and custom methods that do
not override it. Set the :php:`$defaultOrderings` class property:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

    use TYPO3\CMS\Extbase\Persistence\QueryInterface;
    use TYPO3\CMS\Extbase\Persistence\Repository;

    class EventRepository extends Repository
    {
        protected $defaultOrderings = [
            'eventDate' => QueryInterface::ORDER_ASCENDING,
            'title'     => QueryInterface::ORDER_ASCENDING,
        ];
    }

**Method-level ordering** applies only to the query built in that method,
overriding the default for that call. Use :php:`$query->setOrderings()`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

    public function findUpcomingByTitle(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThanOrEqual('eventDate', new \DateTimeImmutable('today'))
        );
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute();
    }

In both cases the keys are **property names**, not column names. Order
direction is :php:`QueryInterface::ORDER_ASCENDING` (:php:`'ASC'`) or
:php:`QueryInterface::ORDER_DESCENDING` (:php:`'DESC'`).

If neither :php:`$defaultOrderings` nor a method-level :php:`setOrderings()`
is set, no :sql:`ORDER BY` clause is added and the database returns rows in an
undefined order. This may appear consistent in development but is not
guaranteed — the order can change after inserts, updates, or database
maintenance. Always define an explicit ordering for any query whose result
order matters to the user.

The TCA :php:`ctrl` settings :php:`default_sortby` and :php:`sortby` are
**not** applied to repository queries — Extbase does not read them for
top-level queries. They do influence the order of child records within
relations (via :php:`foreign_sortby` / :php:`foreign_default_sortby`), but
for any direct repository query the ordering is entirely your responsibility.


..  _extbase-domain-repository-custom-queries:

Custom query methods
====================

Use :php:`createQuery()` when the built-in find methods are not enough:

..  literalinclude:: _snippets/_EventRepository.php
    :language: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

The query API supports these constraint methods:

..  confval-menu::
    :name: extbase-query-constraints
    :display: table
    :type:
    :default:

    ..  confval:: equals(string $property, mixed $value)
        :name: query-equals

        Exact match. Generates a SQL :sql:`=` comparison.

    ..  confval:: like(string $property, string $value)
        :name: query-like

        Pattern match. Generates SQL :sql:`LIKE`. Use :php:`%` as wildcard,
        for example :php:`'%search%'`.

    ..  confval:: lessThan(string $property, mixed $value)
        :name: query-lessthan

        Generates SQL :sql:`<`.

    ..  confval:: lessThanOrEqual(string $property, mixed $value)
        :name: query-lessthanorequal

        Generates SQL :sql:`<=`.

    ..  confval:: greaterThan(string $property, mixed $value)
        :name: query-greaterthan

        Generates SQL :sql:`>`.

    ..  confval:: greaterThanOrEqual(string $property, mixed $value)
        :name: query-greaterthanorequal

        Generates SQL :sql:`>=`.

    ..  confval:: in(string $property, array $values)
        :name: query-in

        Matches any value in the given array. Generates SQL :sql:`IN (...)`.

    ..  confval:: contains(string $property, object $value)
        :name: query-contains

        Checks whether an :php:`ObjectStorage` relation contains the given
        object.

    ..  confval:: logicalAnd(mixed ...$constraints)
        :name: query-logicaland

        Combines multiple constraints with :sql:`AND`.

    ..  confval:: logicalOr(mixed ...$constraints)
        :name: query-logicalor

        Combines multiple constraints with :sql:`OR`.

    ..  confval:: logicalNot(ConstraintInterface $constraint)
        :name: query-logicalnot

        Negates a constraint with :sql:`NOT`.

Chain multiple constraints:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

    $query->matching(
        $query->logicalAnd(
            $query->equals('published', true),
            $query->greaterThanOrEqual('eventDate', new \DateTimeImmutable('today')),
        )
    );

..  seealso::

    `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — the full query reference,
    including ordering, limits, offsets, and the storagePid deep-dive.


..  _extbase-domain-repository-storagepid:

storagePid — when findAll() returns nothing
===========================================

Every repository query (except :php:`findByUid()`) is filtered to one or more
storage pages by default. If :php:`findAll()` returns an empty result and
records clearly exist in the database, the most likely cause is a misconfigured
or missing :php:`storagePid`.

Configure it for example in TypoScript:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    plugin.tx_myextension.persistence.storagePid = 42

..  seealso::

    `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — the full resolution
    chain: TypoScript → plugin-specific TS → FlexForm → PHP override, plus how
    to debug a storagePid problem.


..  _extbase-domain-repository-di:

Dependency injection
====================

Inject the repository via constructor injection in your controller or service.
Do not use :php:`GeneralUtility::makeInstance()`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/EventController.php

    use MyVendor\MyExtension\Domain\Repository\EventRepository;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class EventController extends ActionController
    {
        public function __construct(
            private readonly EventRepository $eventRepository,
        ) {}

        public function listAction(): ResponseInterface
        {
            $this->view->assign('events', $this->eventRepository->findAll());
            return $this->htmlResponse();
        }
    }

TYPO3's DI container resolves the repository automatically. No
:php:`@inject` annotation, no factory call.

..  seealso::

    `Extbase controller actions <https://docs.typo3.org/permalink/extbase-controller-action>`_ — full controller reference
    including how DI works for controllers.


..  _extbase-domain-repository-dbal:

When to drop out of the ORM
============================

The Extbase query API covers most common patterns. Use raw DBAL when you need:

*   Aggregate functions (:sql:`SUM`, :sql:`AVG`, :sql:`GROUP BY`)
*   Bulk inserts or updates across many records
*   Complex multi-table joins that the ORM cannot express
*   Performance-critical queries where loading full objects is wasteful

Access :php:`ConnectionPool` from within the repository:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/EventRepository.php

    use TYPO3\CMS\Core\Database\ConnectionPool;

    public function countByYear(int $year): array
    {
        $connection = $this->connectionPool->getConnectionForTable('tx_myextension_domain_model_event');
        // ... build and execute raw query
    }

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
        parent::__construct();
    }

..  note::

    A full guide to dropping down to DBAL from within Extbase — including when
    the trade-off is worth it — is planned for the persistence chapter.
    See `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_.
