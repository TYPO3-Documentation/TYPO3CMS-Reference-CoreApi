.. include:: /Includes.rst.txt
.. highlight:: php
.. index:: Link Browser
.. _modifyLinkHandlers:

=============================
Events to modify link handler
=============================

You may have to modify the list of available link handlers based on
some dynamic value.

..  versionchanged:: 12.0
    Starting with TYPO3 version 12.0 you can use the following PSR-14 events:

*  :ref:`ModifyAllowedItemsEvent`
*  :ref:`ModifyLinkHandlersEvent`

Supporting both TYPO3 v12 and v11 to modify the available link handlers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you want to be compatible to both TYPO3 v12 and v11, you can keep your
implementation of the hooks
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['LinkBrowser']['hooks']` as
described in :ref:`t3coreapi11:modifyLinkHandlers` and implement the
event listeners at the same time. Remove the hook implementation upon dropping
TYPO3 v11 support.
