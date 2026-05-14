:navigation-title: Common pitfalls

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Common pitfalls
..  _extbase-appendix-pitfalls:

===============================
Common pitfalls in Extbase
===============================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

This page collects the situations that most commonly trip up Extbase
developers — from beginners hitting their first wall to experienced developers
upgrading from older TYPO3 versions. Each entry names the symptom, explains
briefly why it happens, and points to the full discussion.

If something in your extension is not working and you are not sure why, scan
this page first.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-appendix-pitfalls-private-properties:

Model properties declared private are never populated
======================================================

**Symptom:** A model property always holds its default value after loading from
the database, even though the database column contains data. No error is thrown.

**Why:** Extbase :abbr:`hydrates (populates a PHP object with values loaded from the database)` properties via :php:`_setProperty()`, a method
defined on :php:`AbstractDomainObject`. It assigns values using dynamic
property access (:php:`$this->{$propertyName} = $value`). PHP's visibility
rules prevent a parent class method from writing to a :php:`private` property
declared in a child class — the assignment silently does nothing. The same
applies in the other direction: dirty-state tracking cannot read private
properties either, so changes are never persisted.

This catches developers who follow the general good-practice rule of keeping
properties as private as possible. In Extbase models, :php:`protected` is the
correct visibility — not :php:`public`, not :php:`private`.

..  seealso::

    `Defining properties <https://docs.typo3.org/permalink/extbase-domain-model-properties>`_.


..  _extbase-appendix-pitfalls-storagepid:

findAll() returns nothing on an Extbase repository
===================================================

**Symptom:** :php:`$repository->findAll()` (or any repository query) returns
an empty result, but the records clearly exist in the database.

**Why:** Every repository query is filtered to one or more storage pages
(the :php:`storagePid`) by default. If no storage page is configured, or the
records live on a different page than expected, the query returns nothing.
:php:`findByUid()` is the only method that ignores storagePid.

..  seealso::

    `storagePid — when findAll() returns nothing <https://docs.typo3.org/permalink/extbase-domain-repository-storagepid>`_ and the full
    resolution chain in `Persistence queries <https://docs.typo3.org/permalink/extbase-persistence-queries>`_.


..  _extbase-appendix-pitfalls-annotations:

Annotations silently ignored in v14
=====================================

**Symptom:** Lazy loading, cascade delete, or validation rules defined in
DocBlock annotations (:php:`@Extbase\ORM\Lazy`, :php:`@Extbase\Validate`,
etc.) have no effect. No error is thrown.

**Why:** DocBlock annotation support was removed in TYPO3 v14. Extbase simply
ignores them. The replacement is native PHP attributes.

..  seealso::

    `PHP attributes — the v14 way <https://docs.typo3.org/permalink/extbase-domain-model-attributes>`_ and the full attribute
    reference at `Extbase PHP attributes reference <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_.


..  _extbase-appendix-pitfalls-magic-findby:

Magic findBy*() methods removed in v14
========================================

**Symptom:** Calls to :php:`findByTitle($value)`, :php:`findOneBySlug($value)`,
or :php:`countByStatus($value)` throw an error or do nothing after upgrading
to TYPO3 v14.

**Why:** The magic property-name methods were deprecated in v12.3 and removed
in v14. The replacements use an explicit array signature.

..  seealso::

    `Built-in find methods <https://docs.typo3.org/permalink/extbase-domain-repository-find-methods>`_ — migration table
    with before/after examples.


..  _extbase-appendix-pitfalls-list-type:

Plugin registered with list_type no longer works
=================================================

**Symptom:** An existing plugin content element stops rendering after upgrading
to TYPO3 v14, or a newly registered plugin cannot be selected in the backend.

**Why:** The :php:`list_type` / "General Plugin" content element was deprecated
in v13.4 and removed in v14. Plugins must now be registered as dedicated
:php:`CType` content elements.

..  seealso::

    `Frontend plugin registration <https://docs.typo3.org/permalink/extbase-registration-frontend-plugin>`_ — covers the v14
    registration approach and the upgrade wizard required for existing records.


..  _extbase-appendix-pitfalls-abstract-value-object:

AbstractValueObject is not public API
=======================================

**Symptom:** Code extending
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractValueObject` produces
deprecation warnings or breaks unexpectedly.

**Why:** The class is marked :php:`@internal` in v14 — it is not part of the
public Extbase API and may change or be removed without notice. No replacement
class is provided.

**What to do instead:** Implement value objects as plain PHP classes. The DDD
concept is valid; the base class is not.

..  seealso::

    `Value objects <https://docs.typo3.org/permalink/extbase-domain-model-value-objects>`_.


..  _extbase-appendix-pitfalls-frontend-forms-relations:

Frontend form with inline relations produces incomplete saves or silent data loss
================================================================================

**Symptom:** A frontend form that creates or updates a model with inline
relations (speakers, images, tags added dynamically) produces incomplete saves,
orphaned records, or silent data loss for dynamically added fields that fail
HMAC argument hash validation. Trying to replicate the backend's "add another
row" UX via JavaScript makes things worse.

**Why:** Two independent problems compound each other. First, Extbase's
property mapping and persistence layer were not designed to handle a graph of
new and modified related objects submitted in a single form — partial saves and
inconsistent state are the common outcome. Second, TYPO3's HMAC-based argument
hashing protects against mass-assignment attacks by signing the field names
known at render time; dynamically generated field names are not covered and
either fail or require disabling the protection entirely.

**What to do instead:** Avoid the pattern rather than work around it. Concrete
alternatives: split the form into single-object steps; manage relations in a
backend module where the tooling is designed for it; use separate AJAX
endpoints that create one related record at a time; consider DataHandler for
write operations that need IRRE-style relation management.

..  seealso::

    Deeper discussion coming — placement TBD.
    `Controller property mapping <https://docs.typo3.org/permalink/extbase-controller-propertymapping>`_ for the HMAC argument
    hashing mechanism.
