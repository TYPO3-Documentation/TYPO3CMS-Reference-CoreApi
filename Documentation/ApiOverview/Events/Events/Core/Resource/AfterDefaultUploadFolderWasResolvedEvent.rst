..  include:: /Includes.rst.txt
..  index:: Events; AfterDefaultUploadFolderWasResolvedEvent
..  _AfterDefaultUploadFolderWasResolvedEvent:

========================================
AfterDefaultUploadFolderWasResolvedEvent
========================================

..  versionadded:: 12.3
    The event can be used as an improved alternative for the deprecated
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauthgroup.php']['getDefaultUploadFolder']`
    hook, serving the same purpose.

The PSR-14 event
:php:`\TYPO3\CMS\Core\Resource\Event\AfterDefaultUploadFolderWasResolvedEvent`
allows to modify the default upload folder after it has been resolved for the
current page or user.

Example
=======

..  literalinclude:: _AfterDefaultUploadFolderWasResolvedEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Resource/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/Resource/AfterDefaultUploadFolderWasResolvedEvent.rst.txt
