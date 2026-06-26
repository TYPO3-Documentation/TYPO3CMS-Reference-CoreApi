:navigation-title: Repository

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Repository
..  _extbase-domain-repository:

==================
Extbase repository
==================

A repository is the only entry point to the database for any model type.
Controllers and services ask a repository for objects — they **must not** query the
database directly. This keeps persistence logic in one place and makes
controllers easier to test.

Every Extbase extension has one repository per model. The repository class
often only needs to exist and therefore will not require any custom code.

Repositories are registered as shared services in the :ref:`dependency-injection`
container. That means every consumer that injects a given repository within the
same request receives the same instance — query settings configured on it in one
place apply everywhere it is used.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-domain-repository-basics:

A minimal Extbase repository
============================

A repository extends :php:`\TYPO3\CMS\Extbase\Persistence\Repository`. The
class name must follow the convention that the model class
:php:`Domain\Model\Conference` maps to :php:`Domain\Repository\ConferenceRepository`.
Extbase resolves this automatically.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

    namespace MyVendor\MyExtension\Domain\Repository;

    use TYPO3\CMS\Extbase\Persistence\Repository;

    class ConferenceRepository extends Repository {}

This empty class will provide all the standard methods described below without
needing any extra code.


..  _extbase-domain-repository-find-methods:

Built-in find methods in Extbase repositories
=============================================

:php:`Repository` contains these methods for finding, returning, and counting
domain objects out of the box:

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
        For example: :php:`findBy(['published' => true])`.

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

These methods provide an initial overview. The full behaviour *around* a query —
which storage pages and languages it covers, how to limit, order and paginate
results, and how related objects are loaded — is the subject of the persistence
chapter:

..  seealso::

    *   `Querying the database with Extbase <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — storagePid resolution, query settings, limits, pagination, persisting and debugging.

    *   `Object relations in Extbase <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ — relation cardinalities, lazy loading and the N+1 query trap.


..  _extbase-domain-repository-ordering:

Ordering results in Extbase repositories
========================================

There are two distinct places to define the sort order of results, and they serve different
purposes.

**Repository-wide default ordering** applies to every query from this
repository — :php:`findAll()`, :php:`findBy()`, and custom methods that do
not override the order. Set the :php:`$defaultOrderings` class property as follows:

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

**Method-level ordering** applies only to queries built inside the method,
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
direction is set by :php:`QueryInterface::ORDER_ASCENDING` (:php:`'ASC'`) or
:php:`QueryInterface::ORDER_DESCENDING` (:php:`'DESC'`).

As an alternative to using the :php:`setOrderings()` array, the query offers an
easier to read form: :php:`$query->orderBy('title')` sets a single order (replacing
any existing ones), and :php:`$query->addOrderBy('conferenceDate', QueryInterface::ORDER_DESCENDING)`
applies an additional sort order. Both take a property name with an optional direction
that defaults to ascending. Use whichever reads better — they will produce the same
:sql:`ORDER BY` clause.

If neither :php:`$defaultOrderings` nor method-level :php:`setOrderings()`
is set, no :sql:`ORDER BY` clause is added and the database will return rows in an
undefined order. This may appear consistent in development but is not
guaranteed — the order can change after inserts, updates, or database
maintenance. Always define an explicit order for any query where the result
order matters to the user.

..  _extbase-domain-repository-ordering-relations:

Ordering in Extbase relations
-----------------------------

The TCA :php:`ctrl` settings :php:`default_sortby` and :php:`sortby` are
**not** applied to repository queries — Extbase does not read them for
top-level queries. They do influence the order of child records within
relations (via :php:`foreign_sortby` / :php:`foreign_default_sortby`), but
for any direct repository query the sorting order is entirely your responsibility.


..  _extbase-domain-repository-custom-queries:

Custom query methods in Extbase repositories
============================================

Use :php:`createQuery()` when the built-in find methods are not enough. A custom
query method builds a query, constrains it, and executes it:

..  literalinclude:: _snippets/_ConferenceRepository.php
    :caption: EXT:my_extension/Classes/Domain/Repository/ConferenceRepository.php

The full set of constraint methods (:php:`equals()`, :php:`like()`, :php:`in()`,
the comparisons, and combining them with :php:`logicalAnd()` / :php:`logicalOr()`
/ :php:`logicalNot()`), together with worked examples, is documented on the
persistence query page:

..  seealso::

    `Querying the database with Extbase <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — building a query with :php:`createQuery()`, the constraint methods, ordering, limits, offsets, and the storagePid deep-dive.


..  _extbase-domain-repository-storagepid:

storagePid — when findAll() returns nothing
===========================================

A repository query (all except :php:`findByUid()`) queries one or more
particular storage pages by default. If :php:`findAll()` returns an empty result but
records clearly exist in the database, or if there are unexpected objects in the result,
the most likely cause is a missing or misconfigured :php:`storagePid`.

Configure it in TypoScript:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension.persistence.storagePid = 42

..  seealso::

    `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — the full resolution
    chain: TypoScript → plugin-specific TypoScript → FlexForm → PHP override, plus how
    to debug storagePid problems.


..  _extbase-domain-repository-di:

Injecting repositories with dependency injection
================================================

Inject the repository via constructor injection in your controller or service.
Do not use :php:`GeneralUtility::makeInstance()` as this bypasses the
Bootstrap procedure applied by Extbase - any query settings configured in the
shared instance will be lost and the repository will not be wired with its own injected dependencies:

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


TYPO3's :abbr:`DI (Dependency Injection)` container resolves the repository automatically without needing
:php:`@inject` annotation or a factory call.

..  seealso::

    `Extbase controller actions <https://docs.typo3.org/permalink/extbase-controller-action>`_ — full controller reference
    including how DI works in controllers.


..  _extbase-domain-repository-dbal:

When to drop out of ORM (Object Relational Mapping)
===================================================

The Extbase query API covers most common patterns. Use raw
:abbr:`DBAL (Database Abstraction Layer)` — TYPO3's database layer built on top
of Doctrine DBAL — when you need:

*   Aggregate functions (:sql:`SUM`, :sql:`AVG`, :sql:`GROUP BY`)
*   Bulk inserts or updates across many records
*   Complex multi-table joins that the ORM cannot express
*   Performance-critical queries where loading full objects takes too much time

While you can technically access the database directly from controllers or
services, you **should** limit raw DBAL usage to repository classes. Spreading
database calls across controllers and services makes the code harder to test,
makes it harder to change the underlying query, and harder to enforce consistent filters
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
