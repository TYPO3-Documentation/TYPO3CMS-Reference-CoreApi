..  include:: /Includes.rst.txt
..  index:: Events; BeforeModuleCreationEvent
..  _BeforeModuleCreationEvent:

=========================
BeforeModuleCreationEvent
=========================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Module\BeforeModuleCreationEvent`
allows extension authors to manipulate the :ref:`module configuration
<backend-modules-configuration>`, before it is used to create and register the
module.

Example
=======

..  literalinclude:: _BeforeModuleCreationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/BeforeModuleCreationEvent.rst.txt
