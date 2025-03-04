..  include:: /Includes.rst.txt
..  index:: Events; ModifyNewContentElementWizardItemsEvent
..  _ModifyNewContentElementWizardItemsEvent:

=======================================
ModifyNewContentElementWizardItemsEvent
=======================================

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyNewContentElementWizardItemsEvent`
is called after TYPO3 has already prepared the wizard items,
defined in page TSconfig (:ref:`mod.wizards.newContentElement.wizardItems
<t3tsref:pagenewcontentelementwizard>`).

The event allows listeners to modify any available wizard item as well
as adding new ones. It is therefore possible for the listeners to, for example,
change the configuration, the position or to remove existing items altogether.

Example
=======

..  literalinclude:: _ModifyNewContentElementWizardItemsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

..  include:: /_includes/EventsAttributeAdded.rst.txt

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyNewContentElementWizardItemsEvent.rst.txt
