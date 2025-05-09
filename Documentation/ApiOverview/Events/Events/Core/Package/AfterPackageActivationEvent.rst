..  include:: /Includes.rst.txt
..  index:: Events; AfterPackageActivationEvent
..  _AfterPackageActivationEvent:

===========================
AfterPackageActivationEvent
===========================

The PSR-14 event :php:`\TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent`
is triggered after a package has been activated.

..  attention::
    This event is dispatched when an extension is activated in the
    :guilabel:`Extension Manager`, therefore starting with TYPO3 v11 this
    event is only dispatched in Classic mode installations, not in Composer-based
    installations. Use
    `installer events by Composer <https://getcomposer.org/doc/articles/scripts.md#installer-events>`__
    for Composer-based installations.

Example
=======

..  literalinclude:: _AfterPackageActivationEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Package/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/AfterPackageActivationEvent.rst.txt
