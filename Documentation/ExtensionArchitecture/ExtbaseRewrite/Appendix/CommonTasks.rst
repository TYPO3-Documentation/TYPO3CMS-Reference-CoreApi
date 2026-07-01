:navigation-title: Common tasks

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Common tasks
..  _extbase-appendix-tasks:

=======================
Common tasks in Extbase
=======================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

This page answers the "how do I…" questions that come up repeatedly when
building or maintaining Extbase extensions. Each entry states the goal, gives
a short direct answer, and links to the full explanation.

If you know what you want to achieve but are not sure which chapter covers it,
start here.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-appendix-tasks-third-party-field:

Add a field to a third-party extension's model
==============================================

**Goal:** A third-party extension (for example :composer:`georgringer/news`) has a
model you want to extend with an extra database field — without forking the
extension.

**Short answer:** You need three things working together: a TCA override that
adds the column to the table, a class mapping override in your own extension
that tells Extbase to use your subclass instead of the original, and your
subclass extending the third-party model with the new property and
getter/setter. No changes to the original extension required.

**Extension load order matters here.** The class mapping in
:file:`Configuration/Extbase/Persistence/Classes.php` and any DI alias
(used by tools like :composer:`friendsoftypo3/extension-builder` or
:composer:`evoweb/extender`) must be processed after the original extension
registers its own mapping. Declare the third-party extension as a dependency
in your :file:`composer.json` to guarantee this:

..  code-block:: json
    :caption: EXT:my_extension/composer.json

    {
        "require": {
            "georgringer/news": "^11.0"
        }
    }

Without this, the load order is undefined and your class mapping may be
silently overwritten by the original.

..  seealso::

    `Table and field mapping <https://docs.typo3.org/permalink/extbase-domain-model-mapping>`_ for the
    :file:`Configuration/Extbase/Persistence/Classes.php` mapping file.

..  Detailed walkthrough coming in the extending third-party extensions chapter (planned, placement TBD).


..  _extbase-appendix-tasks-custom-query:

Query records with custom conditions
====================================

**Goal:** :php:`findAll()` and :php:`findBy()` are not enough — you need
records filtered by date, a relation, or a combination of conditions.

**Short answer:** Call :php:`$this->createQuery()` in your repository method,
build constraints with :php:`$query->matching()`, and return
:php:`$query->execute()`. For anything the Extbase query API cannot express
(aggregates, complex joins), drop down to :php-short:`\TYPO3\CMS\Core\Database\ConnectionPool` and raw DBAL.

..  seealso::

    * `Custom query methods <https://docs.typo3.org/permalink/extbase-domain-repository-custom-queries>`_ for the basic knowledge.
    * `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ for the full query API
       including ordering, limits, and storagePid settings.


..  _extbase-appendix-tasks-inject-repository:

Use a repository in a controller
================================

**Goal:** Make a repository available inside a controller action without
using :php:`GeneralUtility::makeInstance()`.

**Short answer:** Declare the repository as a constructor parameter with
:php:`protected readonly`. TYPO3's DI container injects it automatically — no
annotation, no factory call needed.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/BlogPostController.php

    class BlogPostController extends ActionController
    {
        public function __construct(
            protected readonly BlogPostRepository $blogPostRepository,
        ) {}
    }

..  seealso::

    * `Dependency injection <https://docs.typo3.org/permalink/extbase-domain-repository-di>`_.
    * `Extbase controller actions <https://docs.typo3.org/permalink/extbase-controller-action>`_ for the full controller setup.


..  _extbase-appendix-tasks-default-ordering:

Set a default sort order for all repository queries
===================================================

**Goal:** Every call to :php:`findAll()` or :php:`findBy()` on a repository
should return records sorted by a specific property, without having to specify
ordering in every call.

**Short answer:** Set the :php:`$defaultOrderings` class property on your
repository. It applies automatically to all queries from that repository.

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Repository/BlogPostRepository.php

    use TYPO3\CMS\Extbase\Persistence\QueryInterface;
    use TYPO3\CMS\Extbase\Persistence\Repository;

    class BlogPostRepository extends Repository
    {
        protected $defaultOrderings = [
            'publishDate' => QueryInterface::ORDER_ASCENDING,
        ];
    }

..  seealso::

    `Ordering <https://docs.typo3.org/permalink/extbase-domain-repository-ordering>`_.


..  _extbase-appendix-tasks-lazy-relation:

Load a relation only when needed
================================

**Goal:** A model has a related object or collection that is expensive to load
and not always needed — for example, the comments on an event in a list view.
You want to avoid loading them unless the template actually uses them.

**Short answer:** Add :php:`#[Lazy]` to the relation property. Extbase defers
the database query until the property is first accessed. For a relation to a
single object, the getter must also handle the :php:`LazyLoadingProxy` intermediate.

..  seealso::

    * `Relations and ObjectStorage <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ for the full pattern
      including the proxy-aware getter.
    * `#[Lazy] <https://docs.typo3.org/permalink/extbase-appendix-attributes-lazy>`_ for the attribute
      reference.
    * `Persistence relations <https://docs.typo3.org/permalink/extbase-persistence-relations>`_ for the N+1 query trap
      this prevents.


..  _extbase-appendix-tasks-delete-cascade:

Delete related objects when the parent is deleted
=================================================

**Goal:** When an event is deleted, its related comment records should be
deleted automatically rather than left as orphans in the database.

**Short answer:** Add :php:`#[Cascade('remove')]` to the relation property on
the owning model. Extbase will delete the related objects through their
repository when the parent is deleted.

..  seealso::

    * `Relations and ObjectStorage <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_.
    * `#[Cascade] <https://docs.typo3.org/permalink/extbase-appendix-attributes-cascade>`_.


..  _extbase-appendix-tasks-enum-property:

Use a native PHP enum as a model property
=========================================

**Goal:** A model property should hold one of a fixed set of values — for
example a status or salutation — and you want to use a native PHP 8.1 backed
enum (an enum with an underlying :php:`string` or :php:`int` value that can be
stored in the database) rather than a plain string or integer.

**Short answer:** Declare the property with the enum type and a default case.
Extbase's built-in :php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\EnumConverter` handles the conversion between the
stored backing value and the enum instance automatically. No extra
configuration needed.

..  seealso::

    `Enum properties <https://docs.typo3.org/permalink/extbase-domain-model-enums>`_.


..  _extbase-appendix-tasks-non-persisted-property:

Add a computed property that is never stored in the database
============================================================

**Goal:** A model needs a property that holds a computed or temporary value —
for example a formatted label derived from other properties — that should never
be written to the database.

**Short answer:** Add :php:`#[Transient]` to the property. Extbase skips it
entirely during read and write operations.

..  seealso::

    * `Non-persisted properties <https://docs.typo3.org/permalink/extbase-domain-model-transient>`_.
    * `#[Transient] <https://docs.typo3.org/permalink/extbase-appendix-attributes-transient>`_.


..  _extbase-appendix-tasks-contentblock-settings:

Let editors set plugin settings in a Content Block FlexForm
===========================================================

**Goal:** Expose a plugin setting (for example "items per page") as an editable
field in a content element, so that an editor can change it without having to
write a FlexForm data structure by hand.

**Short answer:** When you register an Extbase plugin as a Content Block that
is rendered through an :ref:`EXTBASEPLUGIN <t3tsref:cobj-extbaseplugin>` and reuses
the :sql:`pi_flexform` field, a FlexForm field with an identifier like
:yaml:`settings.<name>` will be converted into :php:`$this->settings['<name>']` —
exactly like a TypoScript setting. The reusable :sql:`pages` and
:sql:`recursive` fields likewise feed :typoscript:`persistence.storagePid` and
:typoscript:`persistence.recursive`. This is a little-known mechanism and is becoming
more relevant as Content Block technology moves into the Core.

..  seealso::

    *   `Feeding settings from a Content Block FlexForm <https://docs.typo3.org/permalink/extbase-configuration-typoscript-settings-contentblocks>`_
        for the full example and how the wiring works.

    *   `Create Extbase plugins (Content Blocks documentation) <https://docs.typo3.org/permalink/friendsoftypo3-content-blocks:create-extbase-plugin>`_.
