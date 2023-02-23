..  include:: /Includes.rst.txt
..  index:: Events; ModifyEditFormUserAccessEvent
..  _ModifyEditFormUserAccessEvent:

=============================
ModifyEditFormUserAccessEvent
=============================

..  versionadded:: 12.0
    This event serves as a more powerful and flexible alternative for the removed
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/alt_doc.php']['makeEditForm_accessCheck']`
    hook.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Form\Event\ModifyEditFormUserAccessEvent\ModifyEditFormUserAccessEvent`
provides the full database row of the record in question next to the
exception, which might have been set by the Core. Additionally, the event allows
to modify the user access decision in an object-oriented way, using
convenience methods.

In case any listener to the new event denies user access, while it was initially
allowed by Core, the :php:`\TYPO3\CMS\Backend\Form\Exception\AccessDeniedListenerException`
will be thrown.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyEditFormUserAccessEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

The corresponding event listener class:

..  literalinclude:: _ModifyEditFormUserAccessEvent/_MyEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php


API
===

..  include:: /CodeSnippets/Events/Backend/ModifyEditFormUserAccessEvent.rst.txt
