..  include:: /Includes.rst.txt
..  index:: Events; ModifyButtonBarEvent
..  _ModifyButtonBarEvent:

====================
ModifyButtonBarEvent
====================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent`
can be used to modify the button bar in the TYPO3 backend module
:ref:`docheader <backend-modules-template-without-extbase-docheader>`.

..  seealso::
    *   :ref:`button-components`

Example
=======

..  literalinclude:: _ModifyButtonBarEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyButtonBarEvent.rst.txt
