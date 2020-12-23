.. include:: /Includes.rst.txt
.. index::
   ! Assets
   PageRenderer
.. _assets:

=====================================
Assets (CSS, `JavaScript`:pn:, Media)
=====================================

The TYPO3 component responsible for rendering the HTML and adding assets to a `TYPO3`:pn:
frontend or backend page is called :php:`PageRenderer`.

The :php:`PageRenderer` collects all assets to be rendered, takes care of
options such as concatenation or compression and finally generates the necessary
tags.

There are multiple ways to add assets to the :php:`PageRenderer` in `TYPO3`:pn:.
For configuration options via `TypoScript`:pn: (usually used for the main theme files),
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
times in for example a `Fluid`:pn: template (via :html:`<f:asset.script>` or :html:`<f:asset.css>` `ViewHelpers`:pn:)
but rendered only once in the output.

It supports best practices for optimizing page performance by having a "priority" flag to either
move the asset to the :html:`<head>` section (useful for CSS in above-the-fold concepts) or the
bottom of the :html:`<body>` tag.

The :php:`AssetCollector` helps to work with content elements as components, effectively reducing the CSS to be loaded.
It also incorporates the HTTP/2 power, where it is not relevant to have all
files compressed and concatenated into one file.

The :php:`AssetCollector` is implemented as a singleton and should slowly replace the various other existing options
in `TypoScript`:pn:.

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

.. index:: pair: Assets; ViewHelper

`ViewHelper`:pn:
----------------

There are also two `ViewHelpers`:pn:, the :ref:`f:asset.css<t3viewhelper:typo3-fluid-asset-css>` and the :ref:`f:asset.script<t3viewhelper:typo3-fluid-asset-script>` `ViewHelper`:pn: which use the :php:`AssetCollector` API.

.. index:: pair: Assets; Rendering order

Rendering order
---------------

Currently, CSS and `JavaScript`:pn: registered with the :php:`AssetCollector` will be rendered after their
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

   `JavaScript`:pn: registered with AssetCollector is not affected by
   :ts:`config.moveJsFromHeaderToFooter`.

Examples
--------

Add a `JavaScript`:pn: file to the collector with script attribute :code:`data-foo="bar"`:

.. code-block:: php

    GeneralUtility::makeInstance(AssetCollector::class)
       ->addJavaScript('my_ext_foo', 'EXT:my_ext/Resources/Public/JavaScript/foo.js', ['data-foo' => 'bar']);

Add a `JavaScript`:pn: file to the collector with script attribute :html:`data-foo="bar"` and priority which means rendering before other script tags:

.. code-block:: php

    GeneralUtility::makeInstance(AssetCollector::class)
       ->addJavaScript('my_ext_foo', 'EXT:my_ext/Resources/Public/JavaScript/foo.js', ['data-foo' => 'bar'], ['priority' => true]);

Add a `JavaScript`:pn: file to the collector with :html:`type="module"` (by default, no type= is output for `JavaScript`:pn:):

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

* BeforeJavaScriptsRenderingEvent
* BeforeStylesheetsRenderingEvent

