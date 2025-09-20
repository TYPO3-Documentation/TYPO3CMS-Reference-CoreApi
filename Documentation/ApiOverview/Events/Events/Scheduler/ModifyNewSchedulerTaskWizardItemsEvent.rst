..  include:: /Includes.rst.txt
..  index:: Events; ModifyNewSchedulerTaskWizardItemsEvent
..  _ModifyNewSchedulerTaskWizardItemsEvent:

======================================
ModifyNewSchedulerTaskWizardItemsEvent
======================================

..  versionadded:: 14.0

The PSR-14 event :php:`\TYPO3\CMS\Scheduler\Event\ModifyNewSchedulerTaskWizardItemsEvent`
allows extensions to modify the items in the wizard used to create a new task in
backen module :guilabel:`System > Scheduler`.

..  _ModifyNewSchedulerTaskWizardItemsEvent-example:

Example: Listening for a ModifyNewSchedulerTaskWizardItemsEvent
===============================================================

The following example adds an additional item to the scheduler task wizard,
removes an existing item and modifies one.

..  literalinclude:: _ModifyNewSchedulerTaskWizardItemsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Seo/EventListener/MyEventListener.php

..  _ModifyNewSchedulerTaskWizardItemsEvent-api:

API of ModifyNewSchedulerTaskWizardItemsEvent
=============================================

..  include:: /CodeSnippets/Events/Scheduler/ModifyNewSchedulerTaskWizardItemsEvent.rst.txt
