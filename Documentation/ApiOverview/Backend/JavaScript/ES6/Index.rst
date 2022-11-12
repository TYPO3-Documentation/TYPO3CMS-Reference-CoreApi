.. include:: /Includes.rst.txt
.. index:: JavaScript (Backend); ES6
.. _backend-javascript-es6:

========================
ES6 in the TYPO3 Backend
========================

..  versionchanged:: 12.0
    Starting with TYPO3 v12.0 JavaScript ES6 modules may be used instead of
    AMD modules, both in backend and frontend context.

JavaScript node-js style path resolutions are managed by
`importmaps <https://html.spec.whatwg.org/multipage/webappapis.html#import-maps>`_, which allow web
pages to control the behavior of JavaScript imports.

By the time of writing importmaps are supported natively by Google Chrome,
a polyfill is available for Firefox and Safari and included by TYPO3 core
and applied whenever an importmap is emitted.

For security reasons, importmap configuration is only emitted when the modules
are actually used, that means when a module has been added to the current
page response via :php:`PageRenderer->loadJavaScriptModule()` or
:php:`JavaScriptRenderer->addJavaScriptModuleInstruction()`.
Exposing all module configurations is possible via
:php:`JavaScriptRenderer->includeAllImports()`, but that should only be
done in backend context for logged-in users to avoid disclosing installed
extensions to anonymous visitors.

Configuration
=============

A simple configuration example for an extension that maps
the `Public/JavaScript` folder to an import prefix `@vendor/my-extensions`:

..  literalinclude:: _JavaScriptModulesSimple.php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php

Complex configuration example containing recursive-lookup exclusions,
third-party library definitions and overwrites:

..  literalinclude:: _JavaScriptModulesExtended.php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php

.. _backend-javascript-es6-loading:

Loading ES6
===========

A module can be added to the current page response either via
:php:`PageRenderer` or as :php:`JavaScriptModuleInstruction` via
:php:`JavaScriptRenderer`:

..  literalinclude:: _PageRendererJavaScriptLoading.php
    :caption: EXT:my_extension/Classes/SomeNamespace/SomeClass.php

In a Fluid template the `includeJavaScriptModules` property of the
:html:`<f:be.pageRenderer>` ViewHelper may be used:

..  literalinclude:: _BackendFluidTemplate.html
    :caption: EXT:my_extension/Resources/Private/Backend/Templates/SomeTemplate.html

Some tips on ES6
================

No ES6 JavaScript files are created directly in the TYPO3 Core. JavaScript
is created as TypeScript module which is then converted to ES6 JavaScript
during the build process. However, TypeScript and ES6 are quite similar, you
can therefore look into those files for reference. The TypeScript files can be
found on GitHub at
`Build/Sources/TypeScript <https://github.com/TYPO3/typo3/tree/main/Build/Sources/TypeScript>`__.

For examples of an ES6 JavaScript file have a look at the JavaScript example in
the :ref:`LinkHandler Tutorial <tutorial_backend_link_handler_javascript>` or
the example in the :ref:`Notification API <notification_api>`.

For a practical example on how to introduce ES6 modules into a large extension
see this commit for EXT:news: `[TASK] Add support for TYPO3 v12 ES6
modules <https://github.com/bnf/news/commit/f8e196b67ceaa2f56699fbf464080dde668ad526>`__.

Using JQuery
------------

There is a general tendency to remove dependencies to jQuery in the Core whenever
possible.

If you still have to use jQuery in your third-party extension, include it
with the following statement:

..  code-block:: javascript

    import $ from 'jquery';

.. _requirejs-migration:

Migration from RequireJS
========================

..  note:: For general information on how to migrate from AMD (RequireJS) to
    ES6 see this article: `Arthur Yidi: Migrate JavaScript Modules From AMD
    to ES6 <https://arthuryidi.com/migrate-amd-modules/>`__. This is about 
    the TYPO3 specific details.

RequireJS is shimmed to prefer ES6 modules if available, allowing any extension
to ship ES6 modules by providing an importmap configuration in
:file:`Configuration/JavaScriptModules.php` while providing full backward
compatibility support for extensions that load modules via RequireJS.

Existing RequireJS modules can load new ES6 modules via a bridge that
prefers ES6 modules over traditional RequireJS AMD modules. This allows
extensions authors to migrate to ES6 without breaking dependencies that
previously loaded a module of that extension via RequireJS.

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

Migrate your JavaScript from the AMD module format to native ES6 modules
and register your configuration in
:file:`EXT:my_extension/Configuration/JavaScriptModules.php`, also see
:ref:`backend-javascript-es6-loading` for more information:

..  literalinclude:: _JavaScriptModules.php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php

Then use :php:`TYPO3\CMS\Core\Page\PageRenderer::loadJavaScriptModules()`
instead of :php:`TYPO3\CMS\Core\Page\PageRenderer::loadRequireJsModule()` to
load the ES6 module:

..  literalinclude:: _LoadES6V11Compatible.php
    :caption: EXT:my_extension/Classes/SomeClass.php

In Fluid templates `includeJavaScriptModules` is to be used instead of
`includeRequireJsModules`.

In Fluid template the `includeJavaScriptModules` attribute of the
:html:`<f:be.pageRenderer>` ViewHelper may be used:


..  literalinclude:: _BackendFluidTemplate.html
    :caption: Fluid template for TYPO3 v12 and above

..  code-block:: html
    :caption: Fluid template for TYPO3 v11 and below

    <f:be.pageRenderer
        includeRequireJsModules="{
            0: '@vendor/my-extension/my-example.js'
        }"
    />
