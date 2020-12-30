.. include:: /Includes.rst.txt
.. highlight:: typoscript
.. index:: LinkHandlers
.. _linkhandler:

===================
The LinkHandler API
===================

The LinkHandler API consists of currently 7 LinkHandler classes and the
:php:`TYPO3\CMS\Recordlist\LinkHandler\LinkHandlerInterface`. The
LinkHandlerInterface can be implemented to create custom LinkHandlers.

Most LinkHandlers cannot receive additional configuration, they are marked as
:php:`@internal` and contains neither hooks nor events. They are therefore
of interest to Core developers only.

There are the following LinkHandlers:

* :ref:`pagelinkhandler`: for linking pages and content
* :ref:`recordlinkhandler`: for linking any kind of record
* UrlLinkHandler: for linking external urls
* FileLinkHandler: for linking files in the :ref:`fal`
* FolderLinkHandler: for linking to directories
* MailLinkHandler: for linking mails
* TelephoneLinkHandler: for linking phone numbers

.. note::

   In the system extension :file:`core` there are also classes ending on
   "LinkHandler". However those implement the :php:`interface LinkHandlingInterface`
   and are part of the LinkHandling API, not the LinkHandler API.

The following LinkHandlers are of interest:

.. toctree::
   :titlesonly:

   PageLinkHandler
   RecordLinkHandler
   CustomLinkHandlers
