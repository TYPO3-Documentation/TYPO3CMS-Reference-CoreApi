.. include:: /Includes.rst.txt
.. index:: JavaScript (Backend); ES6
.. _backend-javascript-es6:

========================
ES6 in the TYPO3 Backend
========================

..  todo: Add information on ES6 and its registration
    https://github.com/TYPO3-Documentation/Changelog-To-Doc/issues/5

..  seealso::
    This chapter is still work in progress. For now see the changelog:

    *   :ref:`ext_core:feature-96510`
    *   :ref:`ext_core:feature-98431-1664652179`


.. _backend-javascript-es6-loading:

Loading ES6
===========

..  note::
    This chapter is still work in progress.

.. _requirejs-migration:

Migration from RequireJS
========================

Registering modules via :php:`$pageRenderer->requireJsModules` will still
work in TYPO3 v12. These modules will be loaded after modules registered via
:php:`$pageRenderer->javaScriptModules`. Extensions that use
:php:`$pageRenderer->requireJsModules` will work as before but trigger a
PHP :php:`E_USER_DEPRECATED` error.

If your extension wants to support both TYPO3 v11 and v12 you can keep the
RequireJS version and remove it upon switching to TYPO3 v13.

If you want to prevent deprecation warnings you can also implement both
RequireJS (with a version switch) and native ECMAScript v6/v11 (ES6) modules.
This approach is recommended if you are working with TypeScript and the
JavaScript will be generated anyway.

..  todo: Set link to ES6 description instead of issue once
    https://github.com/TYPO3-Documentation/Changelog-To-Doc/issues/5 is resolved

Migrate your JavaScript from the AMD module format to native ES6 modules
and register your configuration in
:file:`EXT:my_extension/Configuration/JavaScriptModules.php`, also see
:issue:`96510` for more information:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php

    <?php

    return [
        'dependencies' => ['core', 'backend'],
        'imports' => [
            '@vendor/my-extension/' => 'EXT:my_extension/Resources/Public/JavaScript/',
        ],
    ];

Then use :php:`TYPO3\CMS\Core\Page\PageRenderer::loadJavaScriptModules()`
instead of :php:`TYPO3\CMS\Core\Page\PageRenderer::loadRequireJsModule()` to
load the ES6 module:

..  code-block:: php
    :caption: EXT:my_extension/Classes/SomeClass.php

    use TYPO3\CMS\Core\Information\Typo3Version;
    use TYPO3\CMS\Core\Page\PageRenderer;

    $typo3Version = new Typo3Version();
    if ($typo3Version->getMajorVersion() > 11) {
        $this->pageRenderer->loadJavaScriptModule(
            '@vendor/my-extension/my-example.js'
        );
    } else {
        // keep RequireJs for TYPO3 below v12.0
        $this->pageRenderer->loadRequireJsModule(
            'TYPO3/CMS/MyExtension/MyExample'
        );
    }

In Fluid templates `includeJavaScriptModules` is to be used instead of
`includeRequireJsModules`.

In Fluid template the `includeJavaScriptModules` attribute of the
:html:`<f:be.pageRenderer>` ViewHelper may be used:

..  code-block:: html
    :caption: Fluid template for TYPO3 v12 and above

    <f:be.pageRenderer
        includeJavaScriptModules="{
            0: '@vendor/my-extension/my-example.js'
        }"
    />

..  code-block:: html
    :caption: Fluid template for TYPO3 v11 and below

    <f:be.pageRenderer
        includeRequireJsModules="{
            0: '@vendor/my-extension/my-example.js'
        }"
    />
