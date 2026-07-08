..  include:: /Includes.rst.txt
..  index:: Link factory
..  _link-factory:

=====================
Frontend link factory
=====================

The :php:`\TYPO3\CMS\Frontend\Typolink\LinkFactory` class is the main entry point
for generating links in the TYPO3 frontend from PHP. It creates any kind of link:
to a page, a file, a folder, an external URL, an email address, a telephone
number or a database record, such as a news entry.

This functionality previously resided in
:php:`ContentObjectRenderer->typoLink()` and
:php:`ContentObjectRenderer->typoLink_URL()`. It has been extracted into a
dedicated class that only deals with generating links.

..  note::
    For rendering links in :ref:`Fluid <fluid>` templates or TypoScript, the
    established path is still recommended: the ViewHelper
    :ref:`t3viewhelper:typo3-fluid-link-typolink` or the TypoScript function
    :ref:`t3tsref:typolink`. Use :php:`LinkFactory` when an extension needs the
    raw result programmatically, with access to more than just the anchor tag.

The two methods
===============

:php:`LinkFactory` provides two public methods, both returning a
:php:`\TYPO3\CMS\Frontend\Typolink\LinkResultInterface`:

..  option:: create(string $linkText, array $linkConfiguration, ContentObjectRenderer $contentObjectRenderer): LinkResultInterface

    Creates a link from a link text and a TypoLink configuration array. The
    :php:`$linkConfiguration` uses the same keys as a TypoScript
    :ref:`typolink <t3tsref:typolink>`, most importantly :php:`parameter`, and
    optionally :php:`target`, :php:`class`, :php:`title` and
    :php:`additionalParams`. Throws an
    :php:`\TYPO3\CMS\Frontend\Typolink\UnableToLinkException` if the link cannot
    be built.

..  option:: createUri(string $urlParameter, ?ContentObjectRenderer $contentObjectRenderer = null): LinkResultInterface

    Creates a link result for a single TypoLink parameter string, for example
    :php:`'t3://page?uid=42 _blank css-class "My title"'`. Convenient when only
    the URL is needed. The :php:`ContentObjectRenderer` is optional here, so this
    method can also be used outside a typical content rendering context, including
    in the TYPO3 backend.

Obtaining a :php:`LinkFactory` instance
=======================================

Inject :php:`LinkFactory` through :ref:`dependency injection <DependencyInjection>`
and call it from your own service:

..  literalinclude:: _LinkFactory/_MyLinkService.php
    :caption: EXT:my_extension/Classes/Service/MyLinkService.php

Working with the result
=======================

Both methods return a :php:`LinkResultInterface`. It gives programmatic access to
the individual parts of the generated link, rather than only the rendered anchor
tag:

*   :php:`getUrl()` returns the resolved URL.
*   :php:`getType()` returns the link type, for example :php:`page` or
    :php:`email`.
*   :php:`getTarget()` returns the link target.
*   :php:`getLinkText()` returns the link text.
*   :php:`getAttributes()` returns all HTML attributes as an array. A single
    attribute is read with :php:`getAttribute(string $attributeName)`, and its
    presence checked with :php:`hasAttribute(string $attributeName)`.
*   The immutable :php:`withLinkText(string $linkText)`,
    :php:`withTarget(string $target)`,
    :php:`withAttribute(string $attributeName, ?string $attributeValue)` and
    :php:`withAttributes(array $additionalAttributes, bool $resetExistingAttributes = false)`
    methods each return a modified copy of the result.

The concrete :php:`\TYPO3\CMS\Frontend\Typolink\LinkResult` additionally renders
the result:

*   :php:`getHtml()` returns the complete :html:`<a>` anchor tag.
*   :php:`getJson()` returns the link as a JSON string, which is useful for
    headless or API output.

..  code-block:: php
    :caption: Rendering the result in different ways

    $linkResult = $this->linkFactory->createUri('t3://page?uid=42');

    $url = $linkResult->getUrl();       // "/the/page/path"
    $html = $linkResult->getHtml();     // '<a href="/the/page/path">...</a>'
    $json = $linkResult->getJson();     // '{"href":"/the/page/path", ...}'

Examples per link type
======================

The link type is determined by the :php:`parameter` value. The following
examples show the configuration for each type. They all use
:php:`create()`; the same :php:`parameter` values work with
:php:`createUri()` as the first part of the parameter string.

Link to a page
--------------

..  code-block:: php
    :caption: Link to the page with the uid 42

    $linkResult = $this->linkFactory->create(
        'Read more',
        ['parameter' => 't3://page?uid=42'],
        $contentObjectRenderer,
    );

Link to a file
--------------

..  code-block:: php
    :caption: Link to a file by its file uid

    $linkResult = $this->linkFactory->create(
        'Download the file',
        ['parameter' => 't3://file?uid=17'],
        $contentObjectRenderer,
    );

Link to an email address
------------------------

..  code-block:: php
    :caption: Link to an email address

    $linkResult = $this->linkFactory->create(
        'Write us',
        ['parameter' => 'mailto:info@example.org'],
        $contentObjectRenderer,
    );

Link to a telephone number
--------------------------

..  code-block:: php
    :caption: Link to a telephone number

    $linkResult = $this->linkFactory->create(
        'Call us',
        ['parameter' => 'tel:+1234567890'],
        $contentObjectRenderer,
    );

Link to a record
----------------

..  code-block:: php
    :caption: Link to a record, for example a news entry

    $linkResult = $this->linkFactory->create(
        'Read the article',
        ['parameter' => 't3://record?identifier=tx_news&uid=1'],
        $contentObjectRenderer,
    );

How the link is built
=====================

Once :php:`LinkFactory` has determined the link type, the actual link is built
by the matching :ref:`link builder <link-builder>`, and the
:ref:`AfterLinkIsGeneratedEvent <AfterLinkIsGeneratedEvent>` is dispatched so
the result can still be modified. To learn how the individual link types are
resolved, continue with the :ref:`frontend link builder <link-builder>`.
