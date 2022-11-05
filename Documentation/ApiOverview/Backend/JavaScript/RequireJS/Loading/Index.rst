.. include:: /Includes.rst.txt
.. index:: RequireJS; Loading modules
.. _requirejs-loading:

===========================================
Loading your own or other RequireJS modules
===========================================

..  attention::
    ..  deprecated::  12.0
        The RequireJS project has been discontinued_ and was therefore
        replaced by native ECMAScript v6/v11 modules in TYPO3 v12.0. The
        infrastructure for configuration and loading of RequireJS
        modules is deprecated with v12.0 and will be removed in TYPO3 v13. See
        :ref:`RequireJS to ES6 migration <requirejs-migration>`.

.. _discontinued: https://github.com/requirejs/requirejs/issues/1816

In case you use the ready event, you may wonder how to use the module.
Answer: it depends! If you use Fluid's :html:`f:be.pageRenderer` view helper
add the argument :html:`includeRequireJsModules`:

.. code-block:: html

   <f:be.pageRenderer includeRequireJsModules="{
      0:'TYPO3/CMS/FooBar/Wisdom'
   }" />

However, if you don't use Fluid you may use :php:`PageRenderer` in your controller:

.. code-block:: php


   $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
   $pageRenderer->loadRequireJsModule('TYPO3/CMS/FooBar/MyMagicModule');


**Bonus**: :php:`loadRequireJsModule` takes a second argument
:php:`$callBackFunction` which is executed right after the module
was loaded. The callback function must be wrapped within :js:`function() {}`:

.. code-block:: php

   $pageRenderer->loadRequireJsModule(
      'TYPO3/CMS/FooBar/MyMagicModule',
      'function() { console.log("Loaded own module."); }'
   );
