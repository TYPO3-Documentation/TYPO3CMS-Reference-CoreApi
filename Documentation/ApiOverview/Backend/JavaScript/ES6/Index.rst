.. include:: /Includes.rst.txt
.. index:: JavaScript (Backend); ES6
.. _backend-javascript-es6:

========================
ES6 in the TYPO3 Backend
========================

ES6 modules may be used instead of AMD modules, both in backend and frontend context.

JavaScript node-js style path resolutions are managed by
`import maps <https://html.spec.whatwg.org/multipage/webappapis.html#import-maps>`_, which allow web
pages to control the behavior of JavaScript imports.

In November 2022 import maps are supported natively by Google Chrome,
a polyfill is available for Firefox and Safari and included by TYPO3 Core
and applied whenever an import map is emitted.

For security reasons, import map configuration is only emitted when the modules
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
    :language: php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php

Complex configuration example containing recursive-lookup exclusions,
third-party library definitions and overwrites:

..  literalinclude:: _JavaScriptModulesExtended.php
    :language: php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php

.. _backend-javascript-es6-loading:

Loading ES6
===========

A module can be added to the current page response either via
:php:`PageRenderer` or as :php:`JavaScriptModuleInstruction` via
:php:`JavaScriptRenderer`:

..  literalinclude:: _PageRendererJavaScriptLoading.php
    :language: php
    :caption: EXT:my_extension/Classes/SomeNamespace/SomeClass.php

In a Fluid template the `includeJavaScriptModules` property of the
:html:`<f:be.pageRenderer>` ViewHelper may be used:

..  literalinclude:: _BackendFluidTemplate.html
    :language: html
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

In the TYPO3 Core usage of jQuery is eliminated step-by-step as the necessary
functionality is provided by native JavaScript nowadays.

If you still have to use jQuery in your third-party extension, include it
with the following statement:

..  code-block:: javascript

    import $ from 'jquery';

Add JavaScript modules to import map in backend form
====================================================

The JavaScript module import map is static and only generated and
loaded in the first request to a document. All possible future
modules requested in later Ajax calls need to be registered already
in the first initial request.

The tag :php:`backend.form` is used to identify
JavaScript modules that can be used within backend forms. This
ensures that the import maps are available for these modules
even if the element is not displayed directly.

A typical use case for this is an InlineRelationRecord where the
CKEditor is not part of the main record but needs to be loaded for
the child record.

..  literalinclude:: _JavaScriptModulesBackendForm.php
    :language: php
    :caption: EXT:my_extension/Configuration/JavaScriptModules.php
