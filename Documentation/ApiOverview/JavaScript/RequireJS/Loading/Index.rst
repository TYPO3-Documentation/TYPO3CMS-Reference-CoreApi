.. include:: ../../../../Includes.txt






.. _requirejs-loading:

Loading your own or other RequireJS modules
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In case you use the ready event, you may wonder how to use the module.
Answer: it depends! If you use Fluid's :html:`f:be.pageRenderer` view helper
add the argument :html:`includeRequireJsModules`:

.. code-block:: html

   <f:be.pageRenderer includeRequireJsModules="{
      0:'TYPO3/CMS/FooBar/Wisdom'
   }" />

However, if you don't use Fluid you may use :php:`PageRenderer` in e.g `ext_localconf.php`:

.. code-block:: php

   if (TYPO3_MODE=="BE" )   {
      $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
      $pageRenderer->loadRequireJsModule('TYPO3/CMS/FooBar/MyMagicModule');
   }

**Bonus**: :php:`loadRequireJsModule` takes a second argument
:php:`$callBackFunction` which is executed right after the module
was loaded. The callback function must be wrapped within :js:`function() {}`:

.. code-block:: php

   $pageRenderer->loadRequireJsModule(
      'TYPO3/CMS/FooBar/MyMagicModule',
      'function() { console.log("Loaded own module."); }'
   );
