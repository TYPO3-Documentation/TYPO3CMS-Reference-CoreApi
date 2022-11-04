.. include:: /Includes.rst.txt
.. highlight:: php
.. index:: Link Browser
.. _linkbrowser-api:

==========================
Link handler configuration
==========================

.. _linkbrowser-api-description:

Description
===========

Each tab rendered in the link browser has an associated link handler,
responsible for rendering the tab and for creating and editing of
links belonging to this tab.

Here is an example for a custom link handler in the link browser:

..  include:: /Images/ManualScreenshots/Backend/CustomLinkBrowser.rst.txt

In most use cases you can use one of the link handlers provided by the Core.
For an example see :ref:`Tutorial: Custom record link
browser <TableRecordLinkBrowserTutorials>`.

If no link handler is available to deal with your link type, you can create
a custom link handler. See :ref:`Tutorial: Create a custom link
browser <tutorial-github-link-handler>`.

.. index:: Link Browser; Tab registration
.. _linkbrowser-api-tab-registration:

Tab registration
----------------

Link Browser tabs are registered in page TSconfig like this:

..  include:: /CodeSnippets/Tutorials/LinkBrowser/Classes/HaikuRecordLinkBrowserTsconfig.rst.txt

See the complete example: :ref:`Tutorial: Custom record link
browser <TableRecordLinkBrowserTutorials>`.

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the namespace of
    link handlers has changed from
    :php:`TYPO3\CMS\Recordlist\LinkHandler`
    to
    :php:`TYPO3\CMS\Backend\LinkHandler`.
    For TYPO3 v12 the moved classes are available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

Possible options are:

:typoscript:`handler`
    The fully qualified classname of the link handler.

:typoscript:`label`
    The name displayed on the tab button in the link browser.

:typoscript:`displayAfter` / :typoscript:`displayBefore`
    Can be used to decide the order of the tabs.

:typoscript:`scanAfter` / :typoscript:`scanBefore`
    The first backend link handler who determines that it can :ref:`handle the link
    <tutorial_backend_link_handler_canHandleLink>` may edit a link. Most
    likely your links will start with a specific prefix to identify them.

    You should register your tab at least before the `url` link handler.
    The `url` link handler treats all links, that no other handler can treat.

:typoscript:`configuration`
    Some configuration, available to the backend link handler.
