:navigation-title: Backend module

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-registration-backend-module:

=====================================
Registering an Extbase backend module
=====================================

Backend modules are registered via
:file:`Configuration/Backend/Modules.php`. This is the :ref:`standard TYPO3
backend module registration mechanism <backend-modules-api>` which is not
Extbase-specific. Extbase adds two extra keys to the configuration
(:confval:`extensionName <backend-module-extensionName>`
and :confval:`controllerActions <backend-module-controllerActions>`) that tell
TYPO3 to bootstrap Extbase and route requests to an
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-registration-backend-module-modules-php:

Registering the module
======================

Create or extend :file:`Configuration/Backend/Modules.php` in your extension.
Return an array where each key is a unique module identifier and the values are
the module configuration:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/Backend/Modules.php

    use MyVendor\MyExtension\Controller\ConferenceController;

    return [
        'my_extension_conferences' => [
            'parent' => 'web',
            'position' => ['after' => '*'],
            'access' => 'user',
            'path' => '/module/web/my-extension-conferences',
            'iconIdentifier' => 'my-extension-conference-module',
            'labels' => 'my_extension.modules.conferences',
            'extensionName' => 'MyExtension',
            'controllerActions' => [
                ConferenceController::class => [
                    'index', 'show', 'new', 'create', 'edit', 'update', 'delete',
                ],
            ],
        ],
    ];

The Extbase-specific keys are:

:confval:`extensionName <backend-module-extensionName>`
    The extension name in UpperCamelCase, for example, if the extension key is
    ``my_extension`` the extension name will be ``MyExtension``.

:confval:`controllerActions <backend-module-controllerActions>`
    An array mapping controller class names to a list of allowed action names.
    The first entry and its first action are the default. Actions can be set
    as an array (as shown above) or as a comma-separated string.

These two keys instruct TYPO3 to bootstrap Extbase for this module. Do not use
them for modules whose controllers do not extend
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`. Use the
standard :confval:`routes <backend-module-routes>` key instead.

The remaining keys — ``parent``, ``position``, ``access``, ``path``,
``iconIdentifier``, ``labels`` — are standard backend module configuration and
apply to all modules regardless of whether they use Extbase or not. See
:ref:`backend-modules-api` for the full reference.


..  _extbase-registration-backend-module-access:

Access control
==============

The ``access`` key limits who can access the module:

*   ``'user'`` — available to backend users who have been granted access in
    their user or group settings.
*   ``'admin'`` — available to administrators only.
*   ``'systemMaintainer'`` — available to system maintainers only.

User-level access (``'user'``) requires permission to be explicitly granted in
:guilabel:`Backend Users > Edit > Modules`. Admin-only modules skip this check.


..  _extbase-registration-backend-module-labels:

Module labels
=============

The ``labels`` key accepts either a translation label reference or a
translation domain string. Using the
:ref:`domain syntax <label-reference-domain>` introduced in TYPO3 v14:

..  code-block:: php

    'labels' => 'my_extension.modules.conferences',

This resolves to
:file:`EXT:my_extension/Resources/Private/Language/Modules/conferences.xlf`.
The middle segment (``modules``) becomes a subdirectory under
:file:`Resources/Private/Language/`; the last segment (``conferences``)
becomes the filename. The file should define the key ``title`` and optionally
``description`` and ``shortDescription``.

The legacy ``LLL:EXT:`` syntax is equally valid and remains fully supported.


..  _extbase-registration-backend-module-template:

Rendering in the module controller
==================================

Extbase backend module controllers extend
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`, just like
frontend controllers. The key difference is that instead of :php:`$this->view`,
the controller uses a
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` object obtained from
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplateFactory`. The
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` provides
:php:`assign()` and :php:`renderResponse()` methods and wraps the rendered
output in the backend page frame:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ModuleTemplateFactory $moduleTemplateFactory,
            protected readonly ConferenceRepository $conferenceRepository,
        ) {}

        public function indexAction(): ResponseInterface
        {
            $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
            $moduleTemplate->assign('conferences', $this->conferenceRepository->findAll());
            return $moduleTemplate->renderResponse('Conference/Index');
        }
    }

Do not use :php:`$this->view` in a backend module controller. The
:php:`$this->view` object operates in a frontend context — it lacks the backend
link generation, flash message queue, and header components that
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` provides.

:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplateFactory` provides the
backend page frame, toolbar buttons, flash message area, and navigation
components — but only when the Fluid template uses the backend Module Layout.
Without it, :php:`renderResponse()` returns plain rendered HTML with no backend
chrome. Using the Module Layout is strongly recommended for any module that
should look like a native TYPO3 backend page. See :ref:`ModuleTemplateFactory`
for the full :abbr:`API (Application Programming Interface)`.


..  _extbase-registration-backend-module-configuration-assembly:

How the module configuration is assembled
=========================================

When an Extbase backend module handles a request, the framework assembles a
single configuration array from two layers, each able to override the previous:

1.  :typoscript:`module.tx_myextension` — extension-wide defaults, applied to
    every module of this extension.
2.  :typoscript:`module.tx_myextension_mymodule` — module-specific values,
    override the extension-wide layer.

There is no FlexForm layer — backend modules are not content elements and have
no :typoscript:`pi_flexform` record.

The resulting array has three top-level keys that Extbase uses directly:

*   :typoscript:`settings` — arbitrary key/value pairs available as
    :php:`$this->settings` in the controller.
    :php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplate` does not
    auto-assign :html:`{settings}` to the template — pass it explicitly with
    :php:`$moduleTemplate->assign('settings', $this->settings)` when needed.
*   :typoscript:`persistence` — controls record loading; the most relevant
    sub-key is :typoscript:`storagePid`, which limits which page(s) the
    repository queries.
*   :typoscript:`view` — overrides template file resolution via
    :typoscript:`templateRootPaths`, :typoscript:`layoutRootPaths`, and
    :typoscript:`partialRootPaths`.

..  seealso::

    *   :ref:`backend-modules-api` for the full reference for all module configuration
        keys including ``parent``, ``position``, ``access``, ``path``, and
        submodule definitions.

    *   :ref:`ModuleTemplateFactory` for how to add buttons, menus, and
        navigation to the chrome module.
