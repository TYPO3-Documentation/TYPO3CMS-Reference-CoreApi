:navigation-title: Upgrading from older versions

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Upgrading
..  _extbase-upgrading:

=====================================
Upgrading from older Extbase versions
=====================================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

This page lists breaking changes and migration steps for
upgrading an Extbase extension to a newer TYPO3 version. Each entry details
what has changed, which version introduced the change, and what to do.

.. tip::

    Many migrations can be automated, and TYPO3 Rector (:composer:`ssch/typo3-rector`) provides
    rules to do so. The tool is actively maintained and updated for each TYPO3 version that is
    released.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-upgrading-annotations-to-attributes:

Annotations replaced by PHP attributes (TYPO3 v12 / required from v14)
======================================================================

..  versionchanged:: 14.0

    DocBlock annotation support was fully removed. Extbase ignores annotations
    silently — no error is thrown.

Native PHP attributes (introduced in PHP 8.0) replace the Doctrine-based
DocBlock annotation syntax. Extbase has supported PHP attributes since
TYPO3 v12. In TYPO3 v14 the annotation syntax was removed entirely.

+-----------------------------------+-----------------------------------+
| Old annotation (removed in v14)   | New PHP attribute                 |
+===================================+===================================+
| ``@Extbase\ORM\Lazy``             | ``#[Lazy]``                       |
+-----------------------------------+-----------------------------------+
| ``@Extbase\ORM\Cascade("remove")``| ``#[Cascade('remove')]``          |
+-----------------------------------+-----------------------------------+
| ``@Extbase\ORM\Transient``        | ``#[Transient]``                  |
+-----------------------------------+-----------------------------------+
| ``@Extbase\Validate(...)``        | ``#[Validate(...)]``              |
+-----------------------------------+-----------------------------------+
| ``@Extbase\IgnoreValidation``     | ``#[IgnoreValidation]``           |
+-----------------------------------+-----------------------------------+

..  code-block:: diff
    :caption: EXT:my_extension/Classes/Domain/Model/Entity.php

     use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
    +use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
     use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

     class Entity extends AbstractEntity
     {
    -    /**
    -     * @var ObjectStorage<ChildEntity>
    -     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
    -     */
    +    #[Lazy]
         protected ObjectStorage $property;
     }

..  seealso::

    + `ExtbaseAnnotationToAttributeRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#extbaseannotationtoattributerector>`_


..  _extbase-upgrading-attribute-namespace:

Attribute namespace moved from Annotation to Attribute (TYPO3 v14)
==================================================================

..  versionchanged:: 14.0

    The namespace :php:`\TYPO3\CMS\Extbase\Annotation` is deprecated. Class
    aliases remain available in v14 but will be removed in v15. Update your
    :php:`use` statements to :php:`\TYPO3\CMS\Extbase\Attribute` when dropping
    TYPO3 v13 support.

All Extbase attributes have been moved from :php:`\TYPO3\CMS\Extbase\Annotation` to
:php:`\TYPO3\CMS\Extbase\Attribute`.


..  _extbase-upgrading-attribute-array-syntax:

Attribute array syntax deprecated (TYPO3 v14, removed in v15)
=============================================================

..  versionchanged:: 14.0

    Passing a configuration array as the first argument to Extbase attributes
    is deprecated (:ref:`Deprecation #97559 <changelog:deprecation-97559-1760453281>`).
    The array-based syntax still works in v14 but will be removed in v15.

+-------------------------------------------------+-----------------------------+
| Old array syntax (deprecated in v14)            | New named-argument syntax   |
+=================================================+=============================+
| ``#[Cascade(['value' => 'remove'])]``           | ``#[Cascade('remove')]``    |
+-------------------------------------------------+-----------------------------+
| ``#[Validate(['validator' => 'NotEmpty'])]``    | ``#[Validate('NotEmpty')]`` |
+-------------------------------------------------+-----------------------------+

..  important::

    There is **no attribute syntax that is compatible with both TYPO3 v13 and
    v14**. PHP attributes are parsed statically and cannot be conditionally
    defined based on the TYPO3 version. Extensions supporting both versions in
    the same release must keep the array-based syntax and accept the deprecation
    warning in v14.


..  seealso::

    `MigratePassingAnArrayOfConfigurationValuesToExtbaseAttributesRector <https://github.com/sabbelasichon/typo3-rector/blob/main/docs/all_rectors_overview.md#migratepassinganarrayofconfigurationvaluestoextbaseattributesrector>`_


..  _extbase-upgrading-fileupload-named-arguments:

:php:`#[FileUpload]` array syntax replaced by named arguments (TYPO3 v14)
=========================================================================

..  versionchanged:: 14.0

    The array-based configuration syntax for :php:`#[FileUpload]` is deprecated
    and will be removed in TYPO3 v15. Replace the array with named arguments.

In TYPO3 v13, :php:`#[FileUpload]` accepted a single configuration array. In
v14 the attribute requires named arguments instead:

..  code-block:: diff
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    -#[FileUpload([
    -    'validation' => [
    -        'required' => true,
    -        'maxFiles' => 1,
    -        'fileSize' => ['minimum' => '10K', 'maximum' => '2M'],
    -        'mimeType' => ['allowedMimeTypes' => ['image/jpeg', 'image/png']],
    -        'fileExtension' => ['allowedFileExtensions' => ['jpg', 'jpeg', 'png']],
    -    ],
    -    'uploadFolder' => '1:/user_upload/conference_logos/',
    -])]
    +#[FileUpload(
    +    validation: [
    +        'required' => true,
    +        'maxFiles' => 1,
    +        'fileSize' => ['minimum' => '10K', 'maximum' => '2M'],
    +        'mimeType' => ['allowedMimeTypes' => ['image/jpeg', 'image/png']],
    +        'fileExtension' => ['allowedFileExtensions' => ['jpg', 'jpeg', 'png']],
    +    ],
    +    uploadFolder: '1:/user_upload/conference_logos/',
    +)]
     protected ?FileReference $logo = null;

..  important::

    There is **no syntax that is not deprecated in either TYPO3 v13 or v14**.
    Extensions that support both versions in the same release must keep the
    array-based syntax and accept the deprecation warning in v14.

..  seealso::

    *   :ref:`extbase-domain-fileupload` — full reference for the :php:`#[FileUpload]`
        attribute and its named arguments.


..  _extbase-upgrading-ignorevalidation-parameter:

:php:`#[Validate]` and :php:`#[IgnoreValidation]` moved to parameter level (TYPO3 v14, removed in v15)
======================================================================================================

..  versionchanged:: 14.0

    Placing :php:`#[Validate]` and :php:`#[IgnoreValidation]` on the action
    method with a named :php:`$param` / :php:`$argumentName` property is
    deprecated and will be removed in TYPO3 v15.

Before TYPO3 v14, PHP attributes could only be attached to methods, so both
attributes required a named property to identify which parameter they targeted.
TYPO3 v14 introduced support for placing attributes directly on the parameter,
meaning you can now position the attribute on the parameter itself:

..  code-block:: diff
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    -#[Validate(param: 'conference', validator: 'NotEmpty')]
    -#[IgnoreValidation(argumentName: 'conference')]
     public function editAction(
    +    #[Validate(validator: 'NotEmpty')]
    +    #[IgnoreValidation]
         Conference $conference,
     ): ResponseInterface {
     }

..  seealso::

    :ref:`Deprecation #108227 <changelog:deprecation-108227-1763668119>`
    — full deprecation details and automated migration via Rector.


..  _extbase-upgrading-magic-findby:

Magic findBy*(), findOneBy*(), countBy*() methods removed (TYPO3 v14)
=====================================================================

..  versionchanged:: 14.0

    Magic property-name methods were deprecated in TYPO3 v12.3 and removed in
    v14. Replace them with the explicit array-based signatures.

+------------------------------+------------------------------------+
| Old (removed in v14)         | New                                |
+==============================+====================================+
| ``findByTitle($value)``      | ``findBy(['title' => $value])``    |
+------------------------------+------------------------------------+
| ``findOneByTitle($value)``   | ``findOneBy(['title' => $value])`` |
+------------------------------+------------------------------------+
| ``countByTitle($value)``     | ``count(['title' => $value])``     |
+------------------------------+------------------------------------+

:php:`findByUid()` and :php:`findByIdentifier()` are not affected and remain
available.

..  seealso::

    :ref:`t3coreapi/13:extbase-repository-find-by-magic-migration` — the
    migration guide in the TYPO3 v13 branch of this manual.


..  _extbase-upgrading-standalone-view:

StandaloneView removed (TYPO3 v14)
==================================

..  versionchanged:: 14.0

    :php:`\TYPO3\CMS\Fluid\View\StandaloneView` was deprecated in TYPO3 v13
    and removed in v14. The replacement is
    :php-short:`\TYPO3\CMS\Core\View\ViewFactoryInterface` together with
    :php-short:`\TYPO3\CMS\Core\View\ViewFactoryData`.

:php:`StandaloneView` was the historical way to render a Fluid template outside
of a controller, for example, inside a service class, a scheduler task, or an email
renderer. It is no longer available.

The new way injects :php-short:`\TYPO3\CMS\Core\View\ViewFactoryInterface`
and creates a view by passing a
:php-short:`\TYPO3\CMS\Core\View\ViewFactoryData` value object:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Service/MailService.php

    use TYPO3\CMS\Core\View\ViewFactoryData;
    use TYPO3\CMS\Core\View\ViewFactoryInterface;

    readonly class MailService
    {
        public function __construct(
            protected ViewFactoryInterface $viewFactory,
        ) {}

        public function renderTemplate(ServerRequestInterface $request): string
        {
            $view = $this->viewFactory->create(new ViewFactoryData(
                templateRootPaths: ['EXT:my_extension/Resources/Private/Templates/'],
                partialRootPaths: ['EXT:my_extension/Resources/Private/Partials/'],
                layoutRootPaths: ['EXT:my_extension/Resources/Private/Layouts/'],
                request: $request,
            ));
            $view->assign('data', $this->loadData());
            return $view->render('Mail/Notification');
        }
    }

Pass the current :php:`ServerRequestInterface` wherever possible. The view
factory uses it for request-aware rendering (language, base URI, etc.).

..  seealso::

    *   `Deprecation: #104773 — Custom Fluid views and Extbase <https://docs.typo3.org/permalink/changelog:deprecation-104773-1724942036>`_
        changelog entry with full migration notes.


..  _extbase-upgrading-plugin-list-type:

list_type plugin removed; fifth parameter of configurePlugin() restricted (TYPO3 v14)
=====================================================================================

..  versionchanged:: 14.0

    The :php:`list_type` / "General Plugin" content element was removed. All
    plugins must be registered as dedicated :php:`CType` content elements. The
    fifth parameter :php:`$pluginType` of :php:`ExtensionUtility::configurePlugin()`
    now only accepts :php:`'CType'` (or being omitted); any other value throws an
    :php:`\InvalidArgumentException` (:ref:`Important #105538 <changelog:important-105538-1730752784>`).

Older extensions could pass
:php:`ExtensionUtility::PLUGIN_TYPE_PLUGIN_LIST` (``'list_type'``) as the
fifth argument, or register their plugin as a ``list_type`` TCA entry. Both
approaches no longer work in TYPO3 v14.

**What to do:**

*   Remove the fifth argument from :php:`configurePlugin()` or pass
    :php:`ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT`.
*   Provide an upgrade wizard for your extension that extends
    :php:`\TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate` to migrate
    existing content records from :php:`list_type` to the new :php:`CType`.
    TYPO3 does not ship a wizard for extension-specific plugins. Each extension
    must provide its own
    (see :ref:`Deprecation #105076 <changelog:deprecation-105076-1726923626>` for a
    reference implementation).

..  seealso::

    *   `Registering an Extbase frontend plugin <https://docs.typo3.org/permalink/extbase-registration-frontend-plugin>`_
        for the current registration approach.

    *   `Plugin registered with list_type no longer works <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-list-type>`_
        for common pitfalls.


..  _extbase-upgrading-translation-domain-syntax:

Translation domain syntax as shorter alternative to LLL:EXT: (TYPO3 v14)
========================================================================

..  versionadded:: 14.0

    A shorter domain-based syntax for label references was introduced as an
    alternative to the legacy :php:`LLL:EXT:` file path syntax
    (:ref:`Feature #93334 <changelog:feature-93334-1729000000>`).

Legacy syntax remains fully supported and is not deprecated. Both forms
resolve to the same translation entries and can be used interchangeably:

+----------------------------------------------------------------------+--------------------------------------+
| Legacy syntax                                                        | Domain syntax (v14+)                 |
+======================================================================+======================================+
| ``LLL:EXT:my_ext/Resources/Private/Language/locallang.xlf:key``      | ``my_ext.messages:key``              |
+----------------------------------------------------------------------+--------------------------------------+
| ``LLL:EXT:my_ext/Resources/Private/Language/locallang_db.xlf:key``   | ``my_ext.db:key``                    |
+----------------------------------------------------------------------+--------------------------------------+
| ``LLL:EXT:my_ext/Resources/Private/Language/locallang_val.xlf:key``  | ``my_ext.val:key``                   |
+----------------------------------------------------------------------+--------------------------------------+
| ``LLL:EXT:my_ext/Resources/Private/Language/Form/locallang.xlf:key`` | ``my_ext.form.messages:key``         |
+----------------------------------------------------------------------+--------------------------------------+

The domain syntax follows the pattern :php:`extension_key.resource:label_key`.
The resource name is derived from the file name:

*   :file:`locallang.xlf` maps to the fixed resource name ``messages``.
*   :file:`locallang_suffix.xlf` strips the ``locallang_`` prefix, leaving
    ``suffix`` — so :file:`locallang_db.xlf` becomes ``db``.
*   Subdirectories below :file:`Resources/Private/Language/` are prepended as
    dot-separated parts — :file:`Form/locallang.xlf` becomes ``form.messages``.

..  seealso::

    *   :ref:`label-reference-domain` for a full syntax reference and resolution
        rules including the :bash:`language:domain:list` CLI command.


..  _extbase-upgrading-feature-toggle-defaults:

Check Extbase feature toggle defaults after upgrading (TYPO3 v14)
================================================================

..  versionchanged:: 14.0

    The :php:`extbase.consistentDateTimeHandling` feature toggle now defaults to
    :php:`true` for new installations
    (:ref:`Important #106467 <changelog:important-106467-1743452295>`).

Feature toggles behave differently on upgrade than fresh installs: an existing
instance **keeps whatever value it already had**, while a new installation will get
the new default. A toggle whose default changed between versions will therefore
retain the *old* behaviour after an upgrade unless you set it
explicitly. After upgrading to TYPO3 v14 check the values below — the defaults
may not match what your code now expects.

:php:`extbase.consistentDateTimeHandling`
    Introduced in TYPO3 v13.4 and set to :php:`false` by default; new TYPO3 v14
    installations default to :php:`true`. (TYPO3 v12 did not have this toggle.)

    An instance upgraded from v12 or v13 will keep the :php:`false` setting and will
    continue to use
    the **old** :php:`\DateTime` mapping. Certain functionality is missing
    with the :php:`false` setting: correct timezone-offset handling for native datetime fields,
    named timezones instead of fixed offsets (no daylight-saving shifts), correct
    interpretation of integer-based time fields, and support for `00:00:00` as a
    valid time in nullable fields. Many extensions contain timezone workarounds
    that exist *only* to rectify the old behaviour; enabling the toggle
    lets you remove them. Enable it once you have reviewed your
    :php:`\DateTime` handling:

    ..  code-block:: php
        :caption: config/system/settings.php

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['features']['extbase.consistentDateTimeHandling'] = true;

:php:`extbase.enableHistoryTracking`
    Added in TYPO3 v14.2 and set to :php:`false` by default, so you won't get
    an upgrade-preservation surprise, but it is worth knowing that it exists. The global
    feature toggle enables history tracking for **all** Extbase domain model
    tables; individual tables can then opt out via TCA with
    :php:`'ctrl' => ['extbase' => ['enableHistoryTracking' => false]]`. Note the
    GDPR implication: full data snapshots are written to :sql:`sys_history`, so
    disable it for tables holding sensitive data and prune regularly. See
    :ref:`Feature #107289 <changelog:feature-107289-1734172800>`.

..  seealso::

    *   :ref:`extbase-model-datetime-consistency` for the full list of DateTime
        behaviour activated by the toggle.

    *   `Feature toggles (TYPO3 Explained) <https://docs.typo3.org/permalink/t3coreapi:feature-toggles>`_
        for how toggles are stored and edited.
