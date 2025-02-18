..  include:: /Includes.rst.txt
..  index::
    Events; ModifyInfoModuleContentEvent
..  _ModifyInfoModuleContentEvent:

============================
ModifyInfoModuleContentEvent
============================

The PSR-14 event :php:`\TYPO3\CMS\Info\Controller\Event\ModifyInfoModuleContentEvent`
allows the content above and below the info module to be modified. The content
added in the event is displayed in each submodule of :guilabel:`Web > Info`.

The event also provides the :php:`getCurrentModule()` method, which
returns the current requested submodule. It is therefore possible to
limit the added content to a subset of the available submodules.

Next to :php:`getRequest()` and the :php:`getModuleTemplate()`
methods this event also features getters and setters for the header
and footer content.

Access control
==============

The added content is by default always displayed. This event
provides the :php:`hasAccess()` method, returning whether the access checks
in the module were passed by the user.

This way, event listeners can decide on their own, whether their content
should always be shown, or only if a user also has access to the main module
content.

Example
=======

..  literalinclude:: _ModifyInfoModuleContentEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Info/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Info/ModifyInfoModuleContentEvent.rst.txt
