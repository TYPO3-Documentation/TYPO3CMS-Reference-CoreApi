..  include:: /Includes.rst.txt
..  index:: Events; ModifyNewContentElementWizardItemsEvent
..  _ModifyNewContentElementWizardItemsEvent:

=======================================
ModifyNewContentElementWizardItemsEvent
=======================================

..  versionadded:: 12.0
    This event serves as a more powerful and flexible alternative
    for the removed hook :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']`.

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

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyNewContentElementWizardItemsEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

The corresponding event listener class:

..  literalinclude:: _ModifyNewContentElementWizardItemsEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/EventListener/MyEventListener.php

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyNewContentElementWizardItemsEvent.rst.txt
