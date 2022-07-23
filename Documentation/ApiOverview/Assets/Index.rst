.. include:: /Includes.rst.txt
.. index::
   ! Assets
   PageRenderer
.. _assets:

===============================
Assets (CSS, JavaScript, Media)
===============================

.. versionadded:: 10.3

The TYPO3 component responsible for rendering the HTML and adding assets to a TYPO3
frontend or backend page is called :php:`PageRenderer`.

The :php:`PageRenderer` collects all assets to be rendered, takes care of
options such as concatenation or compression and finally generates the necessary
tags.

There are multiple ways to add assets to the :php:`PageRenderer` in TYPO3.
For configuration options via TypoScript (usually used for the main theme files),
see the :ref:`TypoScript Reference <t3tsref:setup-page-includecss-array>`. In extensions,
both directly using the :php:`PageRenderer` as well as using the more convenient
:php:`AssetCollector` is possible.

.. index::
   AssetCollector
   Fluid; asset.script
   Fluid; asset.css

AssetCollector
==============

The :php:`AssetCollector` is a concept to allow custom CSS/JS code, inline or external, to be added multiple
times in e.g. a Fluid template (via :html:`<f:asset.script>` or :html:`<f:asset.css>` Viewhelpers)
but rendered only once in the output.

The :php:`priority` flag (default: :php:`false`) controls where the asset is included:

- JavaScript will be output inside :html:`<head>` if :php:`$priority == true` or at the bottom of the :html:`<body>` tag if :php:`$priority == false`.
- CSS will always be output inside :html:`<head>`, yet grouped by :php:`$priority`.

The :php:`AssetCollector` helps to work with content elements as components, effectively reducing the CSS to be loaded.
It leverages making use of HTTP/2 which removes the necessity to have all
files concatenated into one file.

The :php:`AssetCollector` class is implemented as a singleton (:php:`SingletonInterface`). It replaces various other existing options
in TypoScript and methods in PHP to insert Javascript code and CSS data.

Former methods:

.. code-block:: php

   use TYPO3\CMS\Core\Page\PageRenderer;
   use TYPO3\CMS\Core\Utility\GeneralUtility;

   $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

* :php:`$GLOBALS['TSFE']->additionalHeaderData[$name] = $javascriptcode;`
* :php:`$GLOBALS['TSFE']->setJS($name, $javascriptcode)`
* :php:`$pageRenderer->addHeaderData($javascriptcode)`
* :php:`$pageRenderer->addCssFile($file)`
* :php:`$pageRenderer->addCssInlineBlock($name, $csscode)`
* :php:`$pageRenderer->addCssLibrary($file)`
* :php:`$pageRenderer->addJsFile($file)`
* :php:`$pageRenderer->addJsFooterFile($file)`
* :php:`$pageRenderer->addJsFooterLibrary($name, $file)`
* :php:`$pageRenderer->addJsFooterInlineCode($name, $javascriptcode)`
* :php:`$pageRenderer->addJsInlineCode($name, $javascriptcode)`
* :php:`$pageRenderer->addJsLibrary($name, $file)`


The :php:`AssetCollector` also collects information about "imagesOnPage", which can be used in cached and non-cached components.

The API
-------

.. include:: /CodeSnippets/Manual/Core/AssetCollector.rst.txt

.. note::

   If the same asset is registered multiple times using different attributes or options, both sets are merged. If the
   same attributes or options are given with different values, those registered last will overwrite the existing ones.
   With the `has` methods it can be checked if an asset exists before generating it again, hence avoiding redundancy.

.. index:: pair: Assets; Viewhelpers

ViewHelper
----------

There are also two ViewHelpers, the :ref:`f:asset.css<t3viewhelper:typo3-fluid-asset-css>` and the :ref:`f:asset.script<t3viewhelper:typo3-fluid-asset-script>` Viewhelper which use the :php:`AssetCollector` API.

.. index:: pair: Assets; Rendering order

Rendering order
---------------

Currently, CSS and JavaScript registered with the :php:`AssetCollector` will be rendered after their
:php:`PageRenderer` counterparts. The order is:

- :html:`<head>`
- :typoscript:`page.includeJSLibs.forceOnTop`
- :typoscript:`page.includeJSLibs`
- :typoscript:`page.includeJS.forceOnTop`
- :typoscript:`page.includeJS`
- :php:`AssetCollector::addJavaScript()` with 'priority'
- :typoscript:`page.jsInline`
- :php:`AssetCollector::addInlineJavaScript()` with 'priority'
- :html:`</head>`

- :typoscript:`page.includeJSFooterlibs.forceOnTop`
- :typoscript:`page.includeJSFooterlibs`
- :typoscript:`page.includeJSFooter.forceOnTop`
- :typoscript:`page.includeJSFooter`
- :php:`AssetCollector::addJavaScript()`
- :typoscript:`page.jsFooterInline`
- :php:`AssetCollector::addInlineJavaScript()`

.. note::

   JavaScript registered with AssetCollector is not affected by
   :typoscript:`config.moveJsFromHeaderToFooter`.

Examples
--------

Add a JavaScript file to the collector with script attribute :code:`data-foo="bar"`:

.. code-block:: php

   //use TYPO3\CMS\Core\Page\AssetCollector;
   //use TYPO3\CMS\Core\Utility\GeneralUtility;

   GeneralUtility::makeInstance(AssetCollector::class)
      ->addJavaScript('my_ext_foo', 'EXT:my_ext/Resources/Public/JavaScript/foo.js', ['data-foo' => 'bar']);

Add a JavaScript file to the collector with script attribute :html:`data-foo="bar"` and priority which means rendering before other script tags:

.. code-block:: php

   GeneralUtility::makeInstance(AssetCollector::class)
      ->addJavaScript('my_ext_foo', 'EXT:my_ext/Resources/Public/JavaScript/foo.js', ['data-foo' => 'bar'], ['priority' => true]);

Add a JavaScript file to the collector with :html:`type="module"` (by default, no type= is output for JavaScript):

.. code-block:: php

   GeneralUtility::makeInstance(AssetCollector::class)
      ->addJavaScript('my_ext_foo', 'EXT:my_ext/Resources/Public/JavaScript/foo.js', ['type' => 'module']);

Check if a JavaScript file with the given identifier exists:

.. code-block:: php

   $assetCollector = GeneralUtility::makeInstance(AssetCollector::class);
   if ($assetCollector->hasJavaScript($identifier)) {
       // result: true - JavaScript with identifier $identifier exists
   } else {
       // result: false - JavaScript with identifier $identifier does not exist
   }

.. index::
   pair: Assets; Events
   Events; BeforeJavaScriptsRenderingEvent
   Events; BeforeStylesheetsRenderingEvent

Events
------

There are two events available that allow additional adjusting of assets:

* :ref:`BeforeJavaScriptsRenderingEvent`
* :ref:`BeforeStylesheetsRenderingEvent`

