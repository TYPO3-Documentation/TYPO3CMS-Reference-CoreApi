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
=================================================================================

**Symptom:** A domain object argument arrives in an action with all properties
set to default values even though the form or URL contains data. No error
or validation failure is shown.

**Why:** When a request does not carry a `__trustedProperties` token,
Extbase denies all properties by default to prevent
`mass assignment <https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/07-Input_Validation_Testing/20-Testing_for_Mass_Assignment>`_
attacks. A token is generated automatically by :html:`<f:form>` and covers
the fields rendered in the form exactly. Requests that bypass this — URL
parameters, custom forms without a token, or JSON payloads — don't carry a token,
so properties aren't allowed unless a controller explicitly permits it.

**What to do:** If the request will never carry a `__trustedProperties`
token, add an :php:`initialize*Action()` method and call
:php:`allowProperties()` (or :php:`allowAllProperties()`) on the relevant
argument's property mapping configuration.

..  seealso::

    `Manually allowing properties on Extbase action arguments <https://docs.typo3.org/permalink/extbase-controller-propertymapping-allowproperties>`_
    — how to write the initializer and which methods to use.


..  _extbase-appendix-pitfalls-template-empty:

Template variable renders empty in a Fluid template
===================================================

**Symptom:** A variable or property path in a Fluid template has no output.
No error is thrown and there is no exception in the log. The surrounding HTML
renders normally; only the value is blank.

**Why:** Fluid silently renders an empty string when property resolution fails.
Resolution is attempted in the following order: the public property, :php:`getX()`,
:php:`hasX()`, :php:`isX()`. If none of these exist or they are
accessible, Fluid gives up without raising an error. Common causes:

*   A typo in the property name — :html:`{conference.titel}` instead of
    :html:`{conference.title}` silently produces nothing.
*   A typo in an array key — for arrays, Fluid resolves :html:`{data.title}`
    via :php:`$data['title']`. A missing or misspelled key produces nothing,
    just like a missing property on an object.
*   A :php:`private` property without a public getter — Fluid cannot read a
    :php:`private` property directly. Add a public :php:`getX()` method and
    Fluid will find it regardless of property visibility.
*   A missing getter — a :php:`protected` property without a corresponding
    :php:`getX()` method is invisible to Fluid.
*   The variable was not assigned in the controller — :php:`assign()` was not
    called, or was called under a different name.
*   The variable was not passed to a partial — variables assigned in the
    controller are available in the template, but partials only receive what is
    explicitly passed via :html:`<f:render partial="..." arguments="{conference: conference}" />`.
    Pass each variable by name, or use :html:`arguments="{_all}"` to forward
    everything the template has. :html:`{_all}` is convenient and mostly fine —
    partials tend to grow and need more input over time — but be aware it makes
    the partial's dependencies implicit.
*   A missing TCA column definition — Extbase only hydrates properties that
    have a corresponding column in :php:`$GLOBALS['TCA']`. A model property
    with no TCA column is silently skipped during loading and stays at its
    default value.

**What to do:** Check the exact property name and visibility. Add a
public :php:`getX()` method if one is missing. In the controller, verify that
:php:`$this->view->assign('conference', $conference)` is called with the
correct variable name. In the template itself, use
`f:debug <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-debug>`_
to dump the value at the point of use:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/Show.fluid.html

    <f:debug>{conference}</f:debug>

This renders a formatted dump of the variable, including its type and
accessible properties.

..  _extbase-appendix-pitfalls-fdebug-no-output:

f:debug produces no output
==========================

**Symptom:** :html:`<f:debug>{variable}</f:debug>` is in the template but
nothing appears on the page.

**Why:** There are 2 possible causes and both are common:

*   **Cached output:** Extbase plugin output is cached by default. If the
    page is cached, the rendered HTML — without the debug dump — is served from
    the cache. The ViewHelper will not run again until the cache is cleared.
    Clear the page cache in the TYPO3 backend or temporarily make the plugin
    non-cacheable to force the page to be rerendered.

*   **Production Application Context suppresses debug output:** Default TYPO3
    installations run in a :ref:`Production context <application-context>`. The
    :php:`ProductionErrorHandler` deliberately suppresses debug output to
    avoid leaking internal information to site visitors. In a Production context,
    :html:`f:debug` renders nothing.

    The Application Context must be set via an environment variable or webserver
    configuration — it cannot be changed from inside TYPO3. See
    :ref:`set-application-context` for all available methods. To check which
    context is currently active, open :guilabel:`System > Environment > Environment
    overview` in the TYPO3 backend.

*   **Output is prepended to the page, not rendered in place:** By default
    :html:`f:debug` prepends its output to the top of the DOM rather than
    rendering at the point of use. This means the dump is easy to miss if you
    are looking at a specific section of the page, and it is invisible in JSON
    views or when JavaScript consumes the output. Use :html:`inline="1"` to
    render the dump exactly where the tag appears:

    ..  code-block:: html

        <f:debug inline="1">{conference}</f:debug>

..  seealso::

    `How Fluid accesses object properties <https://docs.typo3.org/permalink/extbase-view-property-access>`_
    for the full resolution order and why :php:`private` properties are
    never accessible.


..  _extbase-appendix-pitfalls-template-not-found:

Template file not found, or wrong template rendered
===================================================

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
*   **Path array key too low:** the overriding path is registered at a key
    lower than the original (for example :typoscript:`5` vs :typoscript:`10`),
    so the original wins. The numeric key is the only thing that determines
    precedence — use a key higher than whatever the original extension uses.

**What to do:** Use the Active TypoScript module in the TYPO3 backend to
inspect the computed :typoscript:`plugin.tx_<extensionkey>.view` paths and
their keys. Verify that file and subdirectory names match the convention
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

**Symptom:** A record is created or edited in the TYPO3 backend without
error, but the same record fails Extbase validation in the frontend or vice
versa. A backend editor saves a record that a frontend action then rejects
immediately. Or a record saved through Extbase arrives in the backend in a
state the backend form cannot open cleanly.

**Why:** Extbase validation (``#[Validate]`` attributes on model properties)
and TCA validation (``eval``, ``required``, and similar TCA column
configuration) are entirely separate systems. Neither one knows about the
other: Extbase validation runs during frontend request processing; TCA
validation runs in the backend form engine. There is no shared layer that
enforces both.

This gap is most painful when multiple Extbase models map to the same database
table. There may be different models carrying different validation rules for a
table, but the backend will always use TCA for that table regardless of which
model class is involved.

**What to do instead:** Treat the two systems as complementary and configure
both deliberately. If a constraint is important in both contexts, add it
both as a ``#[Validate]`` attribute on the model property and as a
corresponding TCA column configuration. For records that must be valid in both
contexts, test both paths.

If a form requires different or stricter validation than the domain model allows
— for example, a multi-step form that validates partial state — consider using a
:abbr:`DTO (Data Transfer Object)`. This is a plain PHP class that includes only
form fields with their validation rules and is separate from the persisted
domain model. DTOs are validated by Extbase. Only successfully validated DTOs are
mapped to models and persisted.

..  seealso::

    `Validation in Extbase <https://docs.typo3.org/permalink/extbase-validation-overview>`_
    — lifecycle, :php:`#[Validate]` placement, and how :php:`errorAction()` is triggered.

..  A working example of the DTO pattern for form validation belongs in the
..  Controller or Validation chapter and should be linked here once written.

..  This section also serves as an argument for keeping the number of Extbase models
..  per table small — the validation gap compounds when multiple models diverge.


..  _extbase-appendix-pitfalls-global-config:

A global config.tx_extbase value breaks an unrelated plugin
===========================================================

**Symptom:** A third-party Extbase plugin that works in a clean installation
misbehaves in a particular TYPO3 instance. A list that should fall back to its
default view returns a 404 for a mistyped action; a detail action that used to
throw a catchable exception now displays "page not found". Nothing
in the extension's TypoScript explains the change, and its code is
unmodified. The same extension behaves correctly in a different installation.

**Why:** Somewhere in the site's TypoScript — typically in a site package — a
framework setting is in the global :typoscript:`config.tx_extbase` scope
instead of in a plugin scope. Because :typoscript:`config.tx_extbase` is the
lowest-precedence layer that applies to **every** Extbase plugin in the
frontend, a value intended to fix one extension silently reconfigures all of
them. A common trigger is copying an MVC error-handling line such as

..  code-block:: typoscript

    config.tx_extbase.mvc.throwPageNotFoundExceptionIfActionCantBeResolved = 1

from a snippet meant for a single plugin. Every installed Extbase plugin that
relied on the default behaviour — fall back to the first registered action —
now returns a 404 instead, including plugins whose authors deliberately depend
on that graceful fallback.

**What to do:** Inspect the computed configuration in the
:guilabel:`Active TypoScript` backend module for both
:typoscript:`config.tx_extbase` and the affected
:typoscript:`plugin.tx_<extensionkey>` tree. Move any framework setting that was
meant for one extension down to that plugin's scope. Reserve
:typoscript:`config.tx_extbase` for a genuine installation-wide policy, and if
a single plugin differs from this, override the key under its own
:typoscript:`plugin.tx_<extensionkey>_<pluginname>` scope, which will take
precedence over the global one.

..  seealso::

    `The global scope: config.tx_extbase <https://docs.typo3.org/permalink/extbase-configuration-typoscript-global-scope>`_
    — what the global scope is for and why it should be used sparingly.


..  _extbase-appendix-pitfalls-flexform-empty-overrides:

A blank FlexForm field silently overrides the TypoScript default
================================================================

**Symptom:** A setting works until a plugin is added to a page, where it takes
the controller's hard-coded fallback instead of the TypoScript value. A
concrete case: :typoscript:`settings.itemsPerPage` is set to `35` in
TypoScript, the controller falls back to `20` if the setting is missing, and
the plugin's FlexForm also exposes an "Items per page" field. The editor never
touches the field. The list paginates at **20** items per page — the
controller fallback — therefore ignoring the `35` that should apply.

**Why:** FlexForm values override TypoScript field by field, and a FlexForm
field that an editor leaves blank is still stored and participates in the
override — but obviously only as an empty value. So :php:`$this->settings['itemsPerPage']` arrives
as an empty string rather than `35`. The controller then sees an empty value, treats
it as "not set", and applies its own fallback of `20`. Nothing errors; the
configured `35` is overwritten before it gets to the controller.

**What to do:** add the field to
:typoscript:`ignoreFlexFormSettingsIfEmpty` so that it does not
overrule the TypoScript default if it is empty:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension_conferencelist.ignoreFlexFormSettingsIfEmpty = itemsPerPage

With this set, the empty FlexForm value will be dropped before the merge and
the TypoScript `35` will survive. In this way you can add every FlexForm field that mirrors a
TypoScript default the editor may legitimately leave blank.

..  seealso::

    `Output format, language overrides and FlexForm handling <https://docs.typo3.org/permalink/extbase-configuration-typoscript-other>`_
    — the :typoscript:`ignoreFlexFormSettingsIfEmpty` reference.
