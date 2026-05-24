:navigation-title: Common pitfalls

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Common pitfalls
..  _extbase-appendix-pitfalls:

==========================
Common pitfalls in Extbase
==========================

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
=====================================================

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
correct visibility — not :php:`private`. Public properties also work and are a
valid, shorter alternative (no getters or setters required), but they bypass
lazy-loading proxies and dirty-state tracking, which can matter for relations.

..  seealso::

    `Defining properties <https://docs.typo3.org/permalink/extbase-domain-model-properties>`_.


..  _extbase-appendix-pitfalls-storagepid:

findAll() returns nothing on an Extbase repository
==================================================

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

Annotations silently ignored in TYPO3 v14
=========================================

**Symptom:** Lazy loading, cascade delete, or validation rules defined in
DocBlock annotations (:php:`@Extbase\ORM\Lazy`, :php:`@Extbase\Validate`,
etc.) have no effect. No error is thrown.

**Why:** DocBlock annotation support was removed in TYPO3 v14. Extbase simply
ignores them. The replacement is native PHP attributes.

..  seealso::

    + :ref:`extbase-upgrading-annotations-to-attributes` — migration steps and
    the full before/after example.

    + `PHP attributes — the v14 way <https://docs.typo3.org/permalink/extbase-domain-model-attributes>`_
    + `Extbase PHP attributes reference <https://docs.typo3.org/permalink/extbase-appendix-attributes>`_.


..  _extbase-appendix-pitfalls-magic-findby:

Magic findBy*() methods removed in TYPO3 v14
============================================

**Symptom:** Calls to :php:`findByTitle($value)`, :php:`findOneBySlug($value)`,
or :php:`countByStatus($value)` throw an error or do nothing after upgrading
to TYPO3 v14.

**Why:** The magic property-name methods were deprecated in v12.3 and removed
in v14. The replacements use an explicit array signature.

..  seealso::

    :ref:`extbase-upgrading-magic-findby` — migration table with before/after
    examples.

    `Built-in find methods <https://docs.typo3.org/permalink/extbase-domain-repository-find-methods>`_ — the current find method reference.


..  _extbase-appendix-pitfalls-list-type:

Plugin registered with list_type no longer works
================================================

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
=====================================

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
=================================================================================

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

..  Deeper discussion coming — placement TBD.
    `Controller property mapping <https://docs.typo3.org/permalink/extbase-controller-propertymapping>`_ for the HMAC argument
    hashing mechanism.


..  _extbase-appendix-pitfalls-property-mapping-denied:

Property mapping denied: form fields not saved without a trusted-properties token
==================================================================================

**Symptom:** A domain object argument arrives in the action with all properties
at their default values even though the form or URL contained data. No error
or validation failure is shown.

**Why:** When a request does not carry a :php:`__trustedProperties` token,
Extbase denies all properties by default to prevent
`mass assignment <https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/07-Input_Validation_Testing/20-Testing_for_Mass_Assignment>`_
attacks. The token is generated automatically by :html:`<f:form>` and covers
exactly the fields rendered in the form. Requests that bypass this — URL
parameters, custom forms without the token, or JSON payloads — carry no token,
so no property is allowed unless the controller explicitly permits it.

**What to do:** If the request will never carry a :php:`__trustedProperties`
token, add an :php:`initialize*Action()` method and call
:php:`allowProperties()` (or :php:`allowAllProperties()`) on the relevant
argument's property mapping configuration.

..  seealso::

    `Manually allowing properties on Extbase action arguments <https://docs.typo3.org/permalink/extbase-controller-propertymapping-allowproperties>`_
    — how to write the initializer and which methods to use.


..  _extbase-appendix-pitfalls-template-empty:

Template variable renders empty in a Fluid template
====================================================

**Symptom:** A variable or property path in a Fluid template outputs nothing.
No error is thrown and no exception appears in the log. The surrounding HTML
renders normally; only the value is blank.

**Why:** Fluid silently renders an empty string when property resolution fails.
Resolution is attempted in this order: a public property, then :php:`getX()`,
then :php:`hasX()`, then :php:`isX()`. If none of these exist or are
accessible, Fluid gives up without raising an error. Common causes:

*   A typo in the property name — :html:`{conference.titel}` instead of
    :html:`{conference.title}` silently produces nothing.
*   A :php:`private` property — Fluid can never access :php:`private`
    properties, even if a getter exists on the same class.
*   A missing getter — a :php:`protected` property without a corresponding
    :php:`getX()` method is invisible to Fluid.
*   The variable was not assigned in the controller — :php:`assign()` was not
    called, or was called under a different name.

**What to do:** Check the exact property name and visibility. Add a
:php:`getX()` method if one is missing. In the controller, verify that
:php:`$this->view->assign('name', $value)` is called with the correct variable
name. In the template itself, use
`f:debug <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-debug>`_
to dump the value at the point of use:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Show.fluid.html

    <f:debug>{conference}</f:debug>

This renders a formatted dump of the variable including its type and all
accessible properties.

..  _extbase-appendix-pitfalls-fdebug-no-output:

f:debug produces no output
==========================

**Symptom:** :html:`<f:debug>{variable}</f:debug>` is in the template but
nothing appears on the page.

**Why:** Two independent causes exist and both are common:

*   **Cached output:** Extbase plugin output is cached by default. Once the
    page is cached, the rendered HTML — without the debug dump — is served from
    the cache. The ViewHelper never runs again until the cache is cleared.
    Clear the page cache in the TYPO3 backend, or make the plugin
    non-cacheable temporarily, to force a fresh render.

*   **Production Application Context suppresses debug output:** A default TYPO3
    installation runs in :ref:`Production context <application-context>`. The
    :php:`ProductionErrorHandler` deliberately suppresses debug output to
    avoid leaking internal information to site visitors. In Production context,
    :html:`f:debug` renders nothing.

    The Application Context must be set via an environment variable or webserver
    configuration — it cannot be changed from inside TYPO3. See
    :ref:`set-application-context` for all available methods. To check which
    context is currently active, open :guilabel:`System > Environment > Environment
    overview` in the TYPO3 backend.

..  seealso::

    `How Fluid accesses object properties <https://docs.typo3.org/permalink/extbase-view-property-access>`_
    — the full resolution order and why :php:`private` properties are
    never accessible.


..  _extbase-appendix-pitfalls-template-not-found:

Template file not found, or wrong template rendered
====================================================

**Symptom:** Extbase throws a "Could not find template file" exception, or
renders a template from a different path than expected — for example, a
customised template is ignored and the original one is used instead.

**Why:** Template resolution is based on a numerically keyed path array
searched from the highest key downward. Several things can go wrong:

*   **Wrong key order:** a customisation registered at key :typoscript:`5` is
    ignored in favour of the original at key :typoscript:`10`, because
    :typoscript:`10` is higher and wins.
*   **Case mismatch on Linux:** :file:`List.fluid.html` and
    :file:`list.fluid.html` are different files. The convention requires an
    uppercase first letter for both the controller subdirectory and the action
    file name.
*   **Controller subdirectory name mismatch:** the subdirectory must match the
    controller class name without the :php:`Controller` suffix —
    :php:`ConferenceController` requires :file:`Conference/`, not
    :file:`Conferences/` or :file:`conference/`.
*   **Extension load order:** when overriding templates from another extension,
    the overriding extension must be loaded after the original so its TypoScript
    is applied last. A missing :file:`composer.json` dependency can cause the
    override to arrive before the original, making the lower key win.

**What to do:** Use the Active TypoScript module in the TYPO3 backend to
inspect the assembled :typoscript:`plugin.tx_<extensionkey>.view` paths and
their keys. Verify file names and subdirectory names match the convention
exactly. Check that the overriding extension declares a dependency on the
original in :file:`composer.json`.

..  seealso::

    *   `Fluid template file resolution in Extbase <https://docs.typo3.org/permalink/extbase-view-templates>`_
        — naming convention, default paths, and key ordering.

    *   `Overriding Fluid templates from a third-party extension <https://docs.typo3.org/permalink/extbase-view-third-party-override>`_
        — extension loading order and path registration.


..  _extbase-appendix-pitfalls-validation-tca-gap:

Extbase model validation and TCA validation are independent
===========================================================

**Symptom:** A record created or edited in the TYPO3 backend passes without
error, but the same record fails Extbase validation in the frontend — or vice
versa. A backend editor saves a record that a frontend action then rejects
immediately. Or a record saved through Extbase arrives in the backend in a
state the backend form cannot open cleanly.

**Why:** Extbase validation (``#[Validate]`` attributes on model properties)
and TCA validation (``eval``, ``required``, and similar TCA column
configuration) are entirely separate systems. Neither one knows about the
other. Extbase validation only runs during frontend request processing; TCA
validation only runs in the backend form engine. There is no shared layer that
enforces both at once.

This gap is most painful when multiple Extbase models map to the same database
table — each model may carry different validation rules, but the backend always
uses the TCA for that table regardless of which model class is involved.

**What to do instead:** Treat the two systems as complementary and configure
both deliberately. For every constraint that matters in both contexts, add it
both as a ``#[Validate]`` attribute on the model property and as the
corresponding TCA column configuration. For records that must be valid in both
contexts, test both paths explicitly.

When a form needs stricter or different validation than the domain model allows
— for example, a multi-step form that validates partial state — consider using a
:abbr:`DTO (Data Transfer Object)`: a plain PHP class that carries only the form
fields and their validation rules, separate from the persisted domain model. The
DTO is validated by Extbase; only a successfully validated DTO is mapped to the
model and persisted.

..  seealso::

    `Validation in Extbase <https://docs.typo3.org/permalink/extbase-validation-overview>`_
    — lifecycle, :php:`#[Validate]` placement, and how :php:`errorAction()` is triggered.

..  A working example of the DTO pattern for form validation belongs in the
..  Controller or Validation chapter and should be linked here once written.

..  This section also serves as an argument for keeping the number of Extbase models
..  per table small — the validation gap compounds when multiple models diverge.

