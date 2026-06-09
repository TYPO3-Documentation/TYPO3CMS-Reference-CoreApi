..  include:: /Includes.rst.txt
..  index:: Events; ModifyNewRecordCreationLinksEvent
..  _ModifyNewRecordCreationLinksEvent:

=================================
ModifyNewRecordCreationLinksEvent
=================================

..  versionadded:: 14.0
    See `Feature: #99459 - Respect record type while creating new records <https://docs.typo3.org/permalink/changelog:feature-99459-1672857664>`_.

The PSR-14 event
:php:`\TYPO3\CMS\Backend\Controller\Event\ModifyNewRecordCreationLinksEvent`
allows the
`New record component in the Contents > Records module <https://docs.typo3.org/permalink/t3coreapi:news-record-component>`_
to be modified.

..  contents:: Table of contents

..  _ModifyNewRecordCreationLinksEvent-example:

Example: Customizing the create new record wizard
=================================================

..  literalinclude:: _ModifyNewRecordCreationLinksEvent/_CustomizeNewRecordWizardEventListener.php
    :caption: EXT:my_extension/Classes/Backend/EventListener/CustomizeNewRecordWizardEventListener.php

..  _ModifyNewRecordCreationLinksEvent-api:

API of ModifyNewRecordCreationLinksEvent
========================================

The event provides access to:

*   :php:`$event->groupedCreationLinks` - The complete structure of creation links
*   :php:`$event->pageTS` - The current page's TSconfig array
*   :php:`$event->pageId` - The current page ID
*   :php:`$event->request` - The current server request object

This allows for comprehensive customization while maintaining backward
compatibility with existing customizations.

..  include:: /CodeSnippets/Events/Backend/ModifyNewRecordCreationLinksEvent.rst.txt

..  _ModifyNewRecordCreationLinksEvent-Datastructure:

Datastructure used in the ModifyNewRecordCreationLinksEvent
-----------------------------------------------------------

The event works with a nested array structure representing grouped creation links:

..  code-block:: php

    [
        'content' => [
            'title' => 'Content',
            'icon' => '<img src="..." />',
            'items' => [
                'sys_file_collection' => [
                    'label' => 'File Collection',
                    'icon' => '<typo3-backend-icon ...>',
                    'types' => [
                        'static' => [
                            'url' => '/typo3/record/edit?edit[sys_file_collection][1]=new&defVals[sys_file_collection][type]=static',
                            'icon' => '<typo3-backend-icon ...>',
                            'label' => 'Static File Collection'
                        ],
                        'folder' => [
                            'url' => '/typo3/record/edit?edit[sys_file_collection][1]=new&defVals[sys_file_collection][type]=folder',
                            'icon' => '<typo3-backend-icon ...>',
                            'label' => 'Folder from Storage'
                        ]
                    ]
                ]
            ]
        ],
        'pages' => [
            'title' => 'Create New Page',
            'icon' => '<typo3-backend-icon ...>',
            'items' => [
                'inside' => [
                    'label' => 'Page (inside)',
                    'icon' => '<typo3-backend-icon ...>',
                    'types' => [
                        '1' => [
                            'url' => '/typo3/record/edit?edit[pages][1]=new&defVals[pages][doktype]=1',
                            'icon' => '<typo3-backend-icon ...>',
                            'label' => 'Standard Page'
                        ],
                        '254' => [
                            'url' => '/typo3/record/edit?edit[pages][1]=new&defVals[pages][doktype]=254',
                            'icon' => '<typo3-backend-icon ...>',
                            'label' => 'Folder'
                        ]
                    ]
                ]
            ]
        ]
    ]
