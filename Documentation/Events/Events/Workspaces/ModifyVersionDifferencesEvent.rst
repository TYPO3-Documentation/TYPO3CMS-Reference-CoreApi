.. include:: /Includes.rst.txt
.. index:: Events; ModifyVersionDifferencesEvent
.. _ModifyVersionDifferencesEvent:


=============================
ModifyVersionDifferencesEvent
=============================

.. versionadded:: 12.0
   This PSR-14 event replaces the
   :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['workspaces']['modifyDifferenceArray']`
   hook.

The event can be used to modify the version differences data, used for the
display in the :guilabel:`Workspaces` backend module. Those data can be accessed
with the :php:`getVersionDifferences()` method and updated using the
:php:`setVersionDifferences(array $versionDifferences)` method.

The version differences :php:`array` contains the differences of each field,
with the following keys:

- :php:`field`: The corresponding field name,
- :php:`label`: The corresponding fields' label,
- :php:`content`: The field values difference

In addition, the event provides the following methods:

- :php:`getLiveRecordData()`: Returns the records live data (used to create the version difference)
- :php:`getParameters()`: Returns meta information like current stage and current workspace

API
===

.. include:: /CodeSnippets/Events/Workspaces/ModifyVersionDifferencesEvent.rst.txt

Example
=======

Registration of the Event in your extensions' :file:`Services.yaml`:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyPackage\Workspaces\MyEventListener:
     tags:
       - name: event.listener
         identifier: 'my-package/workspaces/modify-version-differences'

The corresponding event listener class:

.. code-block:: php
   :caption: my_extension/Classes/Workspaces/MyEventListener.php

   use TYPO3\CMS\Core\Utility\DiffUtility;
   use TYPO3\CMS\Workspaces\Event\ModifyVersionDifferencesEvent;

   final class MyEventListener
   {
       public function __construct(protected readonly DiffUtility $diffUtility)
       {
           $this->diffUtility->stripTags = false;
       }

       public function __invoke(ModifyVersionDifferencesEvent $event): void
       {
           $differences = $event->getVersionDifferences();
           foreach ($differences as $key => $difference) {
               if ($difference['field'] === 'my_test_field') {
                   $differences[$key]['content'] = $this->diffUtility->makeDiffDisplay('a', 'b');
               }
           }

           $event->setVersionDifferences($differences);
       }
   }
