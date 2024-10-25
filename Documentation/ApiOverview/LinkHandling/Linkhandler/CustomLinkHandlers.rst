..  include:: /Includes.rst.txt
..  index:: LinkHandlers; CustomLinkHandlers
..  _customlinkhandler:

=================================
Implementing a custom LinkHandler
=================================

It is possible to implement a custom LinkHandler if links are to be created
and handled that cannot be handled by any of the Core LinkHandlers.

The example below is part of the TYPO3 Documentation Team extension `examples
<https://github.com/TYPO3-Documentation/t3docs-examples>`__.

..  todo: Replace the source code here with the code from EXT:examples
    and adjust the texts
    https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/2298

..  _customlinkhandler-implementation:

Implementing the LinkHandler
============================

You can have a look at the existing LinkHandler in the system extension
"backend", found at :file:`typo3/sysext/backend/Classes/LinkHandler`.

..  versionchanged:: 12.0
    Due to the integration of EXT:recordlist into EXT:backend the path has
    changed from
    :file:`typo3/sysext/recordlist/Classes/LinkHandler`
    to
    :file:`typo3/sysext/backend/Classes/LinkHandler`.
    For TYPO3 v12 the moved classes are available as an alias under the old
    namespace to allow extensions to be compatible with TYPO3 v11 and v12.

However please note that all these extensions extend the
:php:`\TYPO3\CMS\Backend\LinkHandler\AbstractLinkHandler`,
which is marked as :php:`@internal` and subject to change without further notice.

You should therefore implement the interface
:php:`\TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface` in your custom
LinkHandlers:

..  literalinclude:: _CustomLinkHandlers/_GitHubLinkHandler.php
    :caption: EXT:my_extension/Classes/LinkHandler/GitHubLinkHandler.php

..  versionchanged:: 14.0
    Use the :ref:`generic-view-factory` to create a view, previously
    used :php:`TYPO3\CMS\Fluid\View\StandaloneView` was deprecated with TYPO3
    v13.3 and removed with v14.0.

The LinkHandler then has to be registered via page TSconfig:

..  literalinclude:: _CustomLinkHandlers/_page.tsconfig
    :caption: EXT:my_extension/Configuration/page.tsconfig

And the JavaScript, depending on :ref:`requirejs`, has to be added in a file
:file:`Resources/Public/JavaScript/GitHubLinkHandler.js`:

..  literalinclude:: _CustomLinkHandlers/_GitHubLinkHandler.js
    :caption: EXT:my_extension/Resources/Public/JavaScript/GitHubLinkHandler.js

This would create a link looking like this:

..  code-block:: html

   <a href="github:123">Example Link</a>

Which could, for example, be interpreted by a custom protocol handler on a
company computer's operating system.
