.. include:: /Includes.rst.txt
.. index::
   ! Assets
   PageRenderer
.. _assets:

===============================
Assets (CSS, JavaScript, Media)
===============================

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

.. note::

   The :php:`AssetCollector` is available since TYPO3 10.3.

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

- JavaScript will be output inside :html:`<head>` (:php:`priority`=true) or at the bottom of the :html:`<body>` tag (:php:`priority`=false)
- CSS will always be output inside :html:`<head>`, yet grouped by :php:`priority`.

The :php:`AssetCollector` helps to work with content elements as components, effectively reducing the CSS to be loaded.
It leverages making use of HTTP/2 which removes the necessity to have all
files concatenated into one file.

The :php:`AssetCollector` class is implemented as a singleton (:php:`SingletonInterface`). It replaces various other existing options
in TypoScript and methods in PHP to insert Javascript code and CSS data. 

Initialization:

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

- :php:`\TYPO3\CMS\Core\Page\AssetCollector::addJavaScript(string $identifier, string $source, array $attributes, array $options = []): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::addInlineJavaScript(string $identifier, string $source, array $attributes, array $options = []): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::addStyleSheet(string $identifier, string $source, array $attributes, array $options = []): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::addInlineStyleSheet(string $identifier, string $source, array $attributes, array $options = []): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::addMedia(string $fileName, array $additionalInformation): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::removeJavaScript(string $identifier): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::removeInlineJavaScript(string $identifier): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::removeStyleSheet(string $identifier): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::removeInlineStyleSheet(string $identifier): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::removeMedia(string $identifier): self`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::getJavaScripts(?bool $priority = null): array`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::getInlineJavaScripts(?bool $priority = null): array`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::getStyleSheets(?bool $priority = null): array`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::getInlineStyleSheets(?bool $priority = null): array`
- :php:`\TYPO3\CMS\Core\Page\AssetCollector::getMedia(): array`

.. note::

   If the same asset is registered multiple times using different attributes or options, both sets are merged. If the
   same attributes or options are given with different values, those registered last will overwrite the existing ones.

.. index:: pair: Assets; Viewhelpers

Viewhelper
----------

There are also two Viewhelpers, the :ref:`f:asset.css<t3viewhelper:typo3-fluid-asset-css>` and the :ref:`f:asset.script<t3viewhelper:typo3-fluid-asset-script>` Viewhelper which use the :php:`AssetCollector` API.

.. index:: pair: Assets; Rendering order

Rendering order
---------------

Currently, CSS and JavaScript registered with the :php:`AssetCollector` will be rendered after their
:php:`PageRenderer` counterparts. The order is:

- :html:`<head>`
- :ts:`page.includeJSLibs.forceOnTop`
- :ts:`page.includeJSLibs`
- :ts:`page.includeJS.forceOnTop`
- :ts:`page.includeJS`
- :php:`AssetCollector::addJavaScript()` with 'priority'
- :ts:`page.jsInline`
- :php:`AssetCollector::addInlineJavaScript()` with 'priority'
- :html:`</head>`

- :ts:`page.includeJSFooterlibs.forceOnTop`
- :ts:`page.includeJSFooterlibs`
- :ts:`page.includeJSFooter.forceOnTop`
- :ts:`page.includeJSFooter`
- :php:`AssetCollector::addJavaScript()`
- :ts:`page.jsFooterInline`
- :php:`AssetCollector::addInlineJavaScript()`

.. note::

   JavaScript registered with AssetCollector is not affected by
   :ts:`config.moveJsFromHeaderToFooter`.

Examples
--------

Add a JavaScript file to the collector with script attribute :code:`data-foo="bar"`:

.. code-block:: php

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


.. index::
   pair: Assets; Events
   Events; BeforeJavaScriptsRenderingEvent
   Events; BeforeStylesheetsRenderingEvent

Events
------

There are two events available that allow additional adjusting of assets:

* :ref:`BeforeJavaScriptsRenderingEvent`
* :ref:`BeforeStylesheetsRenderingEvent`

