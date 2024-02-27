.. include:: /Includes.rst.txt
.. index:: Link handler; Configuration
.. _link-handler-configuration:

==========================
Link handler configuration
==========================

Link browser tabs are registered in :ref:`page TSconfig <t3tsconfig:pagetsconfig>` like this:

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
    The fully-qualified classname of the link handler.

:typoscript:`label`
    The name displayed on the tab button in the link browser.

:typoscript:`displayAfter` / :typoscript:`displayBefore`
    Can be used to decide the order of the tabs.

:typoscript:`scanAfter` / :typoscript:`scanBefore`
    The first backend link handler who determines that it can :ref:`handle the link
    <tutorial_backend_link_handler_canHandleLink>` may edit a link. Most
    likely your links will start with a :ref:`specific prefix <tutorial-github-link-handler>` to identify them.

    You should register your tab at least before the `url` link handler.
    The `url` link handler treats all links, that no other handler can treat.

:typoscript:`configuration`
    Some custom configuration, available to the backend link handler.

.. _record-link-handler-configuration:

Record link handler configuration
=================================

Record link handlers have the following additional options:

:typoscript:`configuration.hidePageTree = 1`
   Hide the page tree in the link browser

:typoscript:`configuration.storagePid = 84`
   The link browser starts with the given page

:typoscript:`configuration.pageTreeMountPoints = 123,456`
   Only records on these pages and their children will be displayed

Page link handler configuration
===============================

:typoscript:`configuration.pageIdSelector.enabled`
   Enable an additional field in the link browser to enter the uid of a page.

.. figure:: Linkhandler/Images/LinkBrowserTSConfigExamplepageIdSelector.png
   :alt: The link browser field for entering a page uid.

Enable the field with the following page TSConfig:

.. code-block:: typoscript
   :caption: EXT:some_extension/Configuration/page.tsconfig

   TCEMAIN.linkHandler.page.configuration.pageIdSelector.enabled = 1
