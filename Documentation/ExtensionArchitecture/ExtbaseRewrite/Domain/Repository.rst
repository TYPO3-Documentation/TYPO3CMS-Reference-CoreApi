:navigation-title: Repository

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Repository
..  _extbase-domain-repository:

==================
Extbase repository
==================

A repository is the only entry point to the database for a given model type.
Controllers and services ask a repository for objects — they **must not** query the
database directly. This keeps persistence logic in one place and makes
controllers easier to test.

Every Extbase extension has one repository per model. The repository class
often only needs to exist and requires not a single line of custom code.

Repositories are registered as shared services in the :ref:`dependency-injection`
container. That means every consumer that injects a given repository within the
same request receives the same instance — query settings configured on it in one
place apply everywhere it is used.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-domain-repository-basics:

The minimal Extbase repository
==============================

A repository extends :php:`\TYPO3\CMS\Extbase\Persistence\Repository`. The
class name must follow the convention: the model class
:php:`Domain\Model\Conference` maps to :php:`Domain\Repository\ConferenceRepository`.
Extbase resolves this automatically.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    namespace MyVendor\MyExtension\Domain\Repository;

    use TYPO3\CMS\Extbase\Persistence\Repository;

    class ConferenceRepository extends Repository {}

That empty class already provides all the standard methods described below.


..  _extbase-domain-repository-find-methods:

Built-in find methods in Extbase repositories
=============================================

:php:`Repository` provides these methods for finding, returning, and counting domain objects out of the box:

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

..  versionchanged:: 14.0

    Magic find methods (:php:`findByTitle()`, :php:`findOneByTitle()`,
    :php:`countByTitle()`, etc.) were deprecated in v12.3 and removed in v14.
    See :ref:`extbase-upgrading-magic-findby` for the migration table.

These methods are the starting point. The full behaviour *around* every query —
which storage pages and languages it covers, how to limit, order and paginate
results, and how related objects are loaded — is the subject of the persistence
chapter:

..  seealso::

    *   `Querying the database with Extbase <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — storagePid resolution, query settings, limits, pagination, persisting and debugging.

    *   `Object relations in Extbase <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — the relation cardinalities, lazy loading and the N+1 query trap.


..  _extbase-domain-repository-ordering:

Ordering results in Extbase repositories
========================================

There are two distinct places to define ordering, and they serve different
purposes.

**Repository-wide default ordering** applies to every query from this
repository — :php:`findAll()`, :php:`findBy()`, and custom methods that do
not override it. Set the :php:`$defaultOrderings` class property:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    use TYPO3\CMS\Extbase\Persistence\QueryInterface;
    use TYPO3\CMS\Extbase\Persistence\Repository;

    class ConferenceRepository extends Repository
    {
        protected $defaultOrderings = [
            'conferenceDate' => QueryInterface::ORDER_ASCENDING,
            'title'     => QueryInterface::ORDER_ASCENDING,
        ];
    }

**Method-level ordering** applies only to the query built in that method,
overriding the default for that call. Use :php:`$query->setOrderings()`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    public function findUpcomingByTitle(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThanOrEqual('conferenceDate', new \DateTimeImmutable('today'))
        );
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute();
    }

In both cases the keys are **property names**, not column names. Order
direction is :php:`QueryInterface::ORDER_ASCENDING` (:php:`'ASC'`) or
:php:`QueryInterface::ORDER_DESCENDING` (:php:`'DESC'`).

As an alternative to the :php:`setOrderings()` array, the query offers a fluent
form: :php:`$query->orderBy('title')` sets a single ordering (replacing any
existing one), and :php:`$query->addOrderBy('conferenceDate', QueryInterface::ORDER_DESCENDING)`
appends a further ordering. Both take a property name and an optional direction
that defaults to ascending. Use whichever reads better — they produce the same
:sql:`ORDER BY` clause.

If neither :php:`$defaultOrderings` nor a method-level :php:`setOrderings()`
is set, no :sql:`ORDER BY` clause is added and the database returns rows in an
undefined order. This may appear consistent in development but is not
guaranteed — the order can change after inserts, updates, or database
maintenance. Always define an explicit ordering for any query whose result
order matters to the user.

..  _extbase-domain-repository-ordering-relations:

Ordering in Extbase relations
-----------------------------

The TCA :php:`ctrl` settings :php:`default_sortby` and :php:`sortby` are
**not** applied to repository queries — Extbase does not read them for
top-level queries. They do influence the order of child records within
relations (via :php:`foreign_sortby` / :php:`foreign_default_sortby`), but
for any direct repository query the ordering is entirely your responsibility.


..  _extbase-domain-repository-custom-queries:

Custom query methods in Extbase repositories
============================================

Use :php:`createQuery()` when the built-in find methods are not enough:

..  literalinclude:: _snippets/_ConferenceRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The :php:`query <\TYPO3\CMS\Extbase\Persistence\QueryInterface>` API supports these constraint methods:

..  confval-menu::
    :name: extbase-query-constraints
    :display: table
    :type:
    :default:

    ..  confval:: equals(string $property, mixed $value, bool $caseSensitive = true)
        :name: query-equals

        Exact match. Generates a SQL :sql:`=` comparison. For string properties,
        pass :php:`false` as the third argument for a case-insensitive match. If
        :php:`$value` is :php:`null`, a strict :sql:`IS NULL` check is generated.

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

    ..  confval:: count()
        :name: query-count

        Executes the query and returns the number of matching objects without
        hydrating them. Call it on the query after :php:`matching()`, when you
        need a count for the same constraints you would otherwise execute.

Chain multiple constraints:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    $query->matching(
        $query->logicalAnd(
            $query->equals('published', true),
            $query->greaterThanOrEqual('conferenceDate', new \DateTimeImmutable('today')),
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
records clearly exist in the database, or if there are unexpected objects in the result,
the most likely cause is a missing or misconfigured :php:`storagePid`.

Configure it for example in TypoScript:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension.persistence.storagePid = 42

..  seealso::

    `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — the full resolution
    chain: TypoScript → plugin-specific TypoScript → FlexForm → PHP override, plus how
    to debug a storagePid problem.


..  _extbase-domain-repository-di:

Injecting repositories with dependency injection
================================================

Inject the repository via constructor injection in your controller or service.
Do not use :php:`GeneralUtility::makeInstance()` — it bypasses the
Bootstrap procedure applied by extbase, so any query settings configured on the shared instance are lost and the
repository is not wired with its own injected dependencies:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}

        public function listAction(): ResponseInterface
        {
            $this->view->assign('conferences', $this->conferenceRepository->findAll());
            return $this->htmlResponse();
        }
    }


TYPO3's :abbr:`DI (Dependency Injection)` container resolves the repository automatically. No
:php:`@inject` annotation, no factory call.

..  seealso::

    `Extbase controller actions <https://docs.typo3.org/permalink/extbase-controller-action>`_ — full controller reference
    including how DI works for controllers.


..  _extbase-domain-repository-dbal:

When to drop out of the ORM (Object Relational Mapping)
=======================================================

The Extbase query API covers most common patterns. Use raw
:abbr:`DBAL (Database Abstraction Layer)` — TYPO3's database layer built on top
of Doctrine DBAL — when you need:

*   Aggregate functions (:sql:`SUM`, :sql:`AVG`, :sql:`GROUP BY`)
*   Bulk inserts or updates across many records
*   Complex multi-table joins that the ORM cannot express
*   Performance-critical queries where loading full objects is wasteful

While you can technically access the database directly from controllers or
services, you **should** limit raw DBAL usage to repository classes. Spreading
database calls across controllers and services makes the code harder to test,
harder to change the underlying query, and harder to enforce consistent filters
(such as storagePid or language overlay).

Access :php-short:`\TYPO3\CMS\Core\Database\ConnectionPool` from within the repository:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    use TYPO3\CMS\Core\Database\ConnectionPool;
    use TYPO3\CMS\Extbase\Persistence\Repository;

    class ConferenceRepository extends Repository
    {
        public function __construct(
            protected readonly ConnectionPool $connectionPool,
        ) {
            parent::__construct();
        }

        public function countByYear(int $year): array
        {
            $connection = $this->connectionPool->getConnectionForTable('tx_myextension_domain_model_conference');
            // ... build and execute raw query
        }
    }

..  seealso::

    `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_.
