.. include:: /Includes.rst.txt
.. index:: Core link handler
.. _core-link-handler:

=================
Core link handler
=================

The Core link handler, implementing the
:php:`TYPO3\CMS\Core\LinkHandling\LinkHandlingInterface` described here
matches between different internal representations of a link. It is not
to be mixed up with the :ref:`backend link handler <linkhandler>`, commonly
also just called link handler. The latter implements the
:php:`TYPO3\CMS\Backend\LinkHandler\LinkHandlerInterface` and renders a
tab in the link browser.

You can find the built-in Core link handlers in
:file:`EXT:core/Classes/LinkHandling`.

In the tutorial section we provide an example on how to implement a
:ref:`custom Core link handler <tutorial-core-link-handler>`.
