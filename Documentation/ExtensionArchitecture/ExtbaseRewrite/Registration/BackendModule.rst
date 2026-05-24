:navigation-title: Backend module

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Backend module
..  _extbase-registration-backend-module:

=====================================
Registering an Extbase backend module
=====================================

Backend modules are registered via
:file:`Configuration/Backend/Modules.php` — this is the :ref:`standard TYPO3
backend module registration mechanism <backend-modules-api>`, not
Extbase-specific. Extbase adds two extra keys to that configuration
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
Return an array where each key is a unique module identifier and the value is
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
            'labels' => 'my_extension.module_conferences',
            'extensionName' => 'MyExtension',
            'controllerActions' => [
                ConferenceController::class => [
                    'index', 'show', 'new', 'create', 'edit', 'update', 'delete',
                ],
            ],
        ],
    ];

The Extbase-specific keys:

:confval:`extensionName <backend-module-extensionName>`
    The extension name in UpperCamelCase. If the extension key is
    ``my_extension`` the extension name is ``MyExtension``.

:confval:`controllerActions <backend-module-controllerActions>`
    An array mapping controller class names to a list of allowed action names.
    The first entry and its first action are the default. Actions can be given
    as an array (as shown above) or as a comma-separated string.

These two keys instruct TYPO3 to bootstrap Extbase for this module. Do not use
them for modules whose controllers do not extend
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` — use the
standard :confval:`routes <backend-module-routes>` key instead.

The remaining keys — ``parent``, ``position``, ``access``, ``path``,
``iconIdentifier``, ``labels`` — are standard backend module configuration and
apply to all modules regardless of whether they use Extbase. See
:ref:`backend-modules-api` for the full reference.


..  _extbase-registration-backend-module-access:

Access control
==============

The ``access`` key controls who can open the module:

*   ``'user'`` — available to backend users who have been granted access in
    their user or group settings.
*   ``'admin'`` — available to administrators only.
*   ``'systemMaintainer'`` — available to system maintainers only.

User-level access (``'user'``) requires an explicit permission grant in
:guilabel:`Backend Users > Edit > Modules`. Admin-only modules skip this check.


..  _extbase-registration-backend-module-labels:

Module labels
=============

The ``labels`` key accepts either a translation label reference or a
translation domain string. Using the
:ref:`domain syntax <label-reference-domain>` introduced in TYPO3 v14:

..  code-block:: php

    'labels' => 'my_extension.module_conferences',

This resolves to
:file:`EXT:my_extension/Resources/Private/Language/locallang_module_conferences.xlf`.
The file must define at least the keys ``title``, ``description``, and
``shortDescription`` for the module to display correctly in the backend.

The legacy ``LLL:EXT:`` syntax is equally valid and remains fully supported.


..  _extbase-registration-backend-module-template:

Rendering in the module controller
==================================

Extbase backend module controllers extend
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` exactly like
frontend controllers — the same :php:`$this->view->assign()` pattern, the same
Fluid templates. The main addition for backend modules is wrapping the rendered
output in the backend frame using
:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplateFactory`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
    use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

    class ConferenceController extends ActionController
    {
        public function __construct(
            protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        ) {}

        public function indexAction(): ResponseInterface
        {
            $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
            $this->view->assign('conferences', $this->conferenceRepository->findAll());
            $moduleTemplate->setContent($this->view->render());
            return $this->htmlResponse($moduleTemplate->renderResponse());
        }
    }

:php-short:`\TYPO3\CMS\Backend\Template\ModuleTemplateFactory` provides the
backend page frame, toolbar buttons, flash message area, and navigation
components. See :ref:`ModuleTemplateFactory` for the full
:abbr:`API (Application Programming Interface)`.

..  seealso::

    *   :ref:`backend-modules-api` — full reference for all module configuration
        keys including ``parent``, ``position``, ``access``, ``path``, and
        submodule definitions.

    *   :ref:`ModuleTemplateFactory` — how to add buttons, menus, and
        navigation to the module chrome.
