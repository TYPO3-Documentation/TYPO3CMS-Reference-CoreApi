:navigation-title: Assets
..  include:: /Includes.rst.txt
..  index::
    ! Assets
    PageRenderer
..  _assets:

===============================
Assets (CSS, JavaScript, Media)
===============================

..  contents:: **Table of Contents**
    :local:

..  _assets-introduction:

Introduction
============

The TYPO3 component responsible for rendering the HTML and adding assets to a
TYPO3 frontend or backend page is called :php:`\TYPO3\CMS\Core\Page\PageRenderer`.

The :php:`PageRenderer` collects all assets to be rendered, takes care of
options such as concatenation or compression and finally generates the necessary
tags.

There are multiple ways to add assets to the :php:`PageRenderer` in TYPO3.
For configuration options via TypoScript (usually used for the main theme files),
see the :ref:`TypoScript Reference <t3tsref:setup-page-includecss-array>`. In
extensions, both directly using the :php:`PageRenderer` as well as using the
more convenient :php:`AssetCollector` is possible.

.. index::
   AssetCollector
   Fluid; asset.script
   Fluid; asset.css

..  _asset-collector:

Asset collector
===============

With the :php:`\TYPO3\CMS\Core\Page\AssetCollector` class, CSS and JavaScript
code (inline or external) can be added multiple times, but rendered only once in
the output. The class may be used directly in PHP code or the assets can be
added via the :html:`<f:asset.css>` and :html:`<f:asset.script>` ViewHelpers.

The :php:`priority` flag (default: :php:`false`) controls where the asset is
inserted:

-   JavaScript will be output inside :html:`<head>` if :php:`$priority == true`,
    or at the bottom of the :html:`<body>` tag if :php:`$priority == false`.
-   CSS will always be output inside :html:`<head>`, yet grouped by
    :php:`$priority`.

The asset collector helps to work with content elements as components,
effectively reducing the CSS to be loaded. It takes advantage of HTTP/2, which
removes the necessity to concatenate all files in one file.

The asset collector class is implemented as a singleton
(:php:`\TYPO3\CMS\Core\SingletonInterface`). It replaces various other existing
options in TypoScript and :ref:`methods in PHP <assets-other-methods>` for
inserting JavaScript and CSS code.

The asset collector also collects information about images on a page,
which can be used in cached and non-cached components.

..  _asset-collector-api:

The API
-------

..  include:: /CodeSnippets/Manual/Core/AssetCollector.rst.txt

..  note::
    If the same asset is registered multiple times using different attributes or
    options, both sets are merged. If the same attributes or options are given
    with different values, the most recently registered ones overwrite the
    existing ones. The :php:`has` methods can be used to check if an asset
    exists before generating it again, hence avoiding redundancy.


.. index:: pair: Assets; Viewhelpers

..  _assets-viewhelper:

ViewHelper
----------

There are also two ViewHelpers, the
:ref:`f:asset.css<t3viewhelper:typo3-fluid-asset-css>` and the
:ref:`f:asset.script<t3viewhelper:typo3-fluid-asset-script>` ViewHelper which
use the :php:`AssetCollector` API.


.. index:: pair: Assets; Rendering order

..  _assets-rendering-order:

Rendering order
---------------

Currently, CSS and JavaScript registered with the asset collector will be
rendered after their page renderer counterparts. The order is:

-   :html:`<head>`
-   :typoscript:`page.includeJSLibs.forceOnTop`
-   :typoscript:`page.includeJSLibs`
-   :typoscript:`page.includeJS.forceOnTop`
-   :typoscript:`page.includeJS`
-   :php:`AssetCollector::addJavaScript()` with 'priority'
-   :typoscript:`page.jsInline`
-   :php:`AssetCollector::addInlineJavaScript()` with 'priority'
-   :html:`</head>`

-   :typoscript:`page.includeJSFooterlibs.forceOnTop`
-   :typoscript:`page.includeJSFooterlibs`
-   :typoscript:`page.includeJSFooter.forceOnTop`
-   :typoscript:`page.includeJSFooter`
-   :php:`AssetCollector::addJavaScript()`
-   :typoscript:`page.jsFooterInline`
-   :php:`AssetCollector::addInlineJavaScript()`

..  note::
    JavaScript registered with the asset collector is not affected by
    :ref:`config.moveJsFromHeaderToFooter <t3tsref:setup-config-movejsfromheadertofooter>`.

Examples
--------

The :php:`AssetCollector` can be injected in the constructor of a class via
:ref:`dependency injection <DependencyInjection>` and then used in methods:

..  literalinclude:: _MyClassWithAssetCollector.php
    :caption: EXT:my_extension/Classes/MyClass.php

Add a JavaScript file to the collector with script attribute
:html:`data-foo="bar"`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    $this->assetCollector->addJavaScript(
        'my_ext_foo',
        'EXT:my_extension/Resources/Public/JavaScript/foo.js',
        ['data-foo' => 'bar']
    );

Add a JavaScript file to the collector with script attribute
:html:`data-foo="bar"` and a priority which means rendering before other script
tags:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    $this->assetCollector->addJavaScript(
        'my_ext_foo',
        'EXT:my_extension/Resources/Public/JavaScript/foo.js',
        ['data-foo' => 'bar'],
        ['priority' => true]
    );

Add a JavaScript file to the collector with :html:`type="module"` (by default,
no :html:`type=` is output for JavaScript):

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    $this->assetCollector->addJavaScript(
        'my_ext_foo',
        'EXT:my_extension/Resources/Public/JavaScript/foo.js',
        ['type' => 'module']
    );

Check if a JavaScript file with the given identifier exists:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    if ($this->assetCollector->hasJavaScript($identifier)) {
        // result: true - JavaScript with identifier $identifier exists
    } else {
        // result: false - JavaScript with identifier $identifier does not exist
    }


.. index::
   pair: Assets; Events
   Events; BeforeJavaScriptsRenderingEvent
   Events; BeforeStylesheetsRenderingEvent

..  _assets-events:

Events
------

There are two events available that allow additional adjusting of assets:

* :ref:`BeforeJavaScriptsRenderingEvent`
* :ref:`BeforeStylesheetsRenderingEvent`


..  _assets-other-methods:

Former methods to add assets
============================

..  _assets-page-renderer:

Using the page renderer
-----------------------

An instance of the :php:`PageRenderer` class can be injected into the
class via :ref:`dependency injection <DependencyInjection>`:

..  literalinclude:: _MyClassWithPageRenderer.php
    :caption: EXT:my_extension/Classes/MyClass.php

The following methods can then be used:

*   :php:`$this->pageRenderer->addHeaderData($javaScriptCode)`
*   :php:`$this->pageRenderer->addCssFile($file)`
*   :php:`$this->pageRenderer->addCssInlineBlock($name, $cssCode)`
*   :php:`$this->pageRenderer->addCssLibrary($file)`
*   :php:`$this->pageRenderer->addJsFile($file)`
*   :php:`$this->pageRenderer->addJsFooterFile($file)`
*   :php:`$this->pageRenderer->addJsFooterLibrary($name, $file)`
*   :php:`$this->pageRenderer->addJsFooterInlineCode($name, $javaScriptCode)`
*   :php:`$this->pageRenderer->addJsInlineCode($name, $javaScriptCode)`
*   :php:`$this->pageRenderer->addJsLibrary($name, $file)`


..  _assets-TypoScriptFrontendController:

Using the TypoScriptFrontendController
--------------------------------------

..  code-block:: php

    $GLOBALS['TSFE']->additionalHeaderData[$name] = $javaScriptCode;

..  tip::
    Instead of using the global variable for retrieving the
    :ref:`TypoScriptFrontendController <tsfe>` you should consider to use the
    :ref:`PSR-7 request attribute <typo3-request-attributes>`
    :ref:`frontend.controller <typo3-request-attribute-frontend-controller>`
    wherever possible.
