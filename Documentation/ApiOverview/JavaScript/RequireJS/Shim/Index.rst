.. include:: ../../../../Includes.txt






.. _requirejs-shim:

Shim library to use it as own RequireJS modules
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Not all javascript libraries are compatible with RequireJS. In the rarest cases, you can
adjust the library code to be AMD or UMD compatible. So you need to configure RequireJS to
accept the library.

In RequireJS you can use :js:`requirejs.config({})`: to shim a library. In TYPO3 the RequireJS config will
be defined in the :php:`PageRenderer`:.

.. code-block:: php

   $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
   $pageRenderer->addRequireJsConfiguration(
      [
         'paths' => [
            'jquery' => 'sysext/core/Resources/Public/JavaScript/Contrib/jquery/',
            'plupload' => '../typo3conf/ext/your_extension/node_modules/plupload/js/plupload.full.min',
         ],
         'shim' => [
            'deps' => ['jquery'],
            'plupload' => ['exports' => 'plupload'],
         ],
      ]
   );


In this example we configure RequireJS to use plupload. The only dependency is jquery. We already have
jquery in the TYPO3 core extension.

After the shim and export of plupload it is usable in the dependency handling.

.. code-block:: js

   define([
      'jquery',
      'plupload'
   ], function($, plupload) {
      'use strict';
   });

