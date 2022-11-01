.. include:: /Includes.rst.txt
.. index:: LinkBrowser; Custom
.. _tutorial-github-link-handler:

============================
Create a custom link browser
============================

In this tutorial we create a custom link browser tab and the associated
:ref:`backend link handler <tutorial_backend_link_handler>`.

We create a new tab in the link browser window in the TYPO3 backend:

..  include:: /Images/ManualScreenshots/Backend/CustomLinkBrowser.rst.txt

..  tip::
    If you want to link to a record in a custom table, configure the
    :ref:`RecordLinkBrowser <TableRecordLinkBrowserTutorials>`. You do not
    need a custom link browser in that scenario.

We introduce a :ref:`custom link format <tutorial-core-link-handler>` to store
the links in this format: `t3://github?issue=123`.

This enables us to edit an existing link in the
link browser or to change parts of the GitHub URI programmatically later.

And we :ref:`render the new link in the frontend <tutorial-typolink-builder>`
automatically.

**Step by step to a custom link browser**

..  contents::
    :local:

.. _tutorial_backend_link_handler:

1. Create a link browser tab
============================

To create a link browser tab we implement the interface
:php:`\TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface`.

All backend link handlers provided by the Core extend the abstract class
:php:`TYPO3\CMS\Backend\LinkHandler\AbstractLinkHandler`. However, this class is
marked as :php:`@internal` and therefore can be changed by the Core Team at any time.

You have the choice of implementing the :php:`LinkHandlerInterface` yourself by
having a look at the :php:`AbstractLinkHandler` for best practices or to extend
the :php:`AbstractLinkHandler`. In the latter case your code might break on
updates though.

In this tutorial, we implement the :php:`LinkHandlerInterface` directly, as it is
best practice not to rely on internal classes.

You can find the complete class in the extension EXT:examples on GitHub:
`GitHubLinkHandler <https://github.com/TYPO3-Documentation/t3docs-examples/blob/main/Classes/LinkHandler/GitHubLinkHandler.php>`__.

We will explain some of the important methods below:

Initialization and dependencies
-------------------------------

..  include:: /ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerInitialize.rst.txt

For technical reasons, not all dependencies needed by the backend link handler can
be acquired by :ref:`DependencyInjection`. Therefore the following two methods
are called by Core classes once the dependencies are available:

:php:`LinkHandlerInterface::initialize()` takes care of setting the
:php:`\TYPO3\CMS\Backend\Controller\AbstractLinkBrowserController`, the identifier and
the configuration information. In this example we only need the configuration,
the other parameters might be needed in different scenarios. The
:php:`\TYPO3\CMS\Core\Page\PageRenderer` has also to be created here for as it
is not possible to inject it at the point of creation of the backend link handler.

The method :php:`setView()` is called by the :php:`AbstractLinkBrowserController`
once the view is available and contains the necessary information to render
the link browser window.

..  note::
    :php:`setView()` is not part of the :php:`LinkHandlerInterface`
    and its call is an implementation detail that might be
    changed in the future.

Render the link browser tab
---------------------------

The method :php:`LinkHandlerInterface::render()` is called when the tab should
be rendered. It registers the required JavaScript in the page renderer, assigns
variables to the view and returns the rendered HTML.

..  include:: /ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerRender.rst.txt

Set the link via JavaScript
---------------------------

When the button in the rendered form is clicked to set a link, a custom
JavaScript class interprets the form data and creates the link to be stored:

..  todo: Configure code snippet tool to remove or shorten the license comment here

..  include:: /ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_CustomLinkHandlerJavaScript.rst.txt

It is important that the JavaScript function calls
:js:`LinkBrowser.finalizeFunction()`. Otherwise no link will be set.

If not done yet, the JavaScript has to be registered in the file
:file:`EXT:my_extension/Configuration/JavaScriptModules.php`. Otherwise it
will not be found by :php:`$pageRenderer->loadJavaScriptModule()`.

..  literalinclude:: _CustomLinkBrowser/_JavaScriptModules.php
    :caption: EXT:examples/Configuration/JavaScriptModules.php

As our JavaScript class depends on classes provided by the backend system extension,
:php:`backend` has to be added as dependency. See also
:ref:`backend-javascript-es6-loading`.

Can we handle this link?
------------------------

The method :php:`LinkHandlerInterface::canHandleLink()` is called when the
user edits an existing link in the link browser. All backend link handlers will
be called and can decide if they can handle that link. If so, they should store
the provided information to be used in rendering (for example, to fill an input
field with the old value).

..  include:: /ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandlerCanHandleLink.rst.txt

Format current URL
------------------

The function :php:`LinkHandlerInterface::formatCurrentUrl()` is used to preview
what the link will look like in the backend, for example, in the upper part of
the link browser window.

..  attention::
    :php:`LinkHandlerInterface::formatCurrentUrl()` is not used to render the
    link in the frontend.

..  _tutorial-core-link-handler:

2. Introduce the custom link format
===================================

You can find the complete class in the extension EXT:examples on GitHub:
`GitHubLinkHandling <https://github.com/TYPO3-Documentation/t3docs-examples/blob/main/Classes/LinkHandler/GitHubLinkHandling.php>`__.

Our :ref:`backend link handler implementation from step 1 <tutorial_backend_link_handler>`
saves the link in the custom format `t3://github?issue=123` via JavaScript.

This format is only an arbitrary string until we tell TYPO3 how to handle links
of the new format by a second class which implements the
:php:`TYPO3\CMS\Core\LinkHandling\LinkHandlingInterface`.

..  note::
    There are two interfaces with very similar names and very different
    functionality involved here. The
    :php:`\TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface` renders a tab in
    the link browser window in the backend. Its implementing class is commonly
    called a "(backend) link handler". Classes implementing the interface
    :php:`TYPO3\CMS\Core\LinkHandling\LinkHandlingInterface` handle the
    introduced link format. Such a class is called a "(core) link handler".

..  include:: /ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GitHubLinkHandling.rst.txt

The method :php:`LinkHandlingInterface::asString()` creates a string
representation from the parameter array.

:php:`LinkHandlingInterface::resolveHandlerData()` receives a parsed version of
the string representation of the link and creates the parameter array from it.

..  _tutorial-typolink-builder:

3. Render the custom link format in the frontend
================================================

The link builder, a class extending the abstract class
:php:`\TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder` is called whenever
a link is rendered in the frontend, for example via
TypoScript :typoscript:`.typolink`, by the
:php:`\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::typoLink`
function or by the :php:`\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder`.

..  include:: /ApiOverview/LinkBrowser/Tutorials/_CustomLinkBrowser/_GithubLinkBuilder.rst.txt

The function :php:`AbstractTypolinkBuilder::build()` is called with the link
configuration and data from the typolink function. If the link can be rendered,
it returns a new :php:`\TYPO3\CMS\Frontend\Typolink\LinkResultInterface`. The
actual rendering of the link depends on the context the link is rendered in
(for example HTML or JSON).

If the link cannot be built it should throw a
:php:`\TYPO3\CMS\Frontend\Typolink\UnableToLinkException`.
