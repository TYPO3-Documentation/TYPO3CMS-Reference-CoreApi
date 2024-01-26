..  include:: /Includes.rst.txt
..  highlight:: php
..  index::
    pair: Link handler; Events
..  _modifyLinkHandlers:

=============================
Events to modify link handler
=============================

You may have to modify the list of available link handlers based on
some dynamic value:

*   :ref:`ModifyAllowedItemsEvent`
*   :ref:`ModifyLinkHandlersEvent`

..  versionadded:: 13.0

Another event allows you to resolve custom link types, but also to modify the
link result data of existing link handlers:

*   :ref:`AfterLinkResolvedByStringRepresentationEvent`

If you want to be compatible to both TYPO3 v13 and v12, you can keep your
implementation of the
:php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Link']['resolveByStringRepresentation']`
and implement the event listener at the same time. Remove the hook
implementation when dropping TYPO3 v12 support.
