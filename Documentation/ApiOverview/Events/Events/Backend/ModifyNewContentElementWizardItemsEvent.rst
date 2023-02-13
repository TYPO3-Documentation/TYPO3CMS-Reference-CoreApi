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
<t3tsconfig:pagenewcontentelementwizard>`).

The event allows listeners to modify any available wizard item as well
as adding new ones. It is therefore possible for the listeners to, for example,
change the configuration, the position or to remove existing items altogether.

Example
=======

Registration of the event in your extension's :file:`Services.yaml`:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

    MyVendor\MyExtension\Backend\MyEventListener:
      tags:
        - name: event.listener
          identifier: 'my-extension/backend/modify-wizard-items'

The corresponding event listener class:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Backend/MyEventListener.php

    namespace MyVendor\MyExtension\Backend;

    use TYPO3\CMS\Backend\Controller\Event\ModifyNewContentElementWizardItemsEvent;

    final class MyEventListener {
        public function __invoke(ModifyNewContentElementWizardItemsEvent $event): void
        {
            // Add a new wizard item after "textpic"
            $event->setWizardItem(
                'my_element',
                [
                    'iconIdentifier' => 'icon-my-element',
                    'title' => 'My element',
                    'description' => 'My element description',
                    'tt_content_defValues' => [
                        'CType' => 'my_element'
                    ],
                ],
                ['after' => 'common_textpic']
            );
        }
    }

API
===

..  include:: /CodeSnippets/Events/Backend/ModifyNewContentElementWizardItemsEvent.rst.txt
