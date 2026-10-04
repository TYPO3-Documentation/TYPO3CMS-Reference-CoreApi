..  include:: /Includes.rst.txt
..  index:: Events; ModifyButtonBarEvent
..  _ModifyButtonBarEvent:

======================
`ModifyButtonBarEvent`
======================

The PSR-14 event :php:`\TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent`
can be used to modify the button bar in the TYPO3 backend module
:ref:`docheader <backend-modules-template-without-extbase-docheader>`.

The :guilabel:`Reload` and :guilabel:`Bookmark` buttons that TYPO3 adds to
every module are already in the button bar when the event is dispatched, so
a listener can change or remove them as well.

..  seealso::
    *   :ref:`Button components <button-components>`
    *   :ref:`Reload and bookmark buttons
        <docheadercomponent-automatic-buttons>`

..  _modify-button-bar-event-example:

Example
=======

..  literalinclude:: _ModifyButtonBarEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  _modify-button-bar-event-api:

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyButtonBarEvent.rst.txt
