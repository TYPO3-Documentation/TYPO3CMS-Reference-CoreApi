.. include:: /Includes.rst.txt
.. index:: LinkHandlers; CustomLinkHandlers
.. _customlinkhandler:

=================================
Implementing a custom LinkHandler
=================================

It is possible to implement a custom LinkHandler if links are to be created
and handled that cannot be handled by any of the Core LinkHandlers.

The example below is part of the TYPO3 Documentation Team extension `examples
<https://github.com/TYPO3-Documentation/TYPO3CMS-Code-Examples>`__.


Implementing the LinkHandler
============================

You can have a look at the existing LinkHandler in the system Extension
recordlist, found at :file:`typo3/sysext/recordlist/Classes/LinkHandler`.

However please not that all these extensions extend the :php:`AbstractLinkHandler`,
which is marked as :php:`@interenal` and subject to change without further notice.

You should therefore implement the :php:`interface LinkHandlerInterface` in your
own custom LinkHandlers.
