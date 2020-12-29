.. include:: /Includes.rst.txt
.. index::
   Events; AfterPageColumnsSelectedForLocalizationEvent
   Events; LocalizationController
.. _AfterPageColumnsSelectedForLocalizationEvent:

============================================
AfterPageColumnsSelectedForLocalizationEvent
============================================

Event to listen to after the form engine has been initialized (and all data has been persisted).

The PSR-14 event :php:`\TYPO3\CMS\Backend\Controller\Event\AfterPageColumnsSelectedForLocalizationEvent`
will be dispatched after records and columns are collected in the :php:`LocalizationController`.

The event receives:

* The default columns and columns list built by :php:`LocalizationController`
* The list of records that were analyzed to create the columns manifest
* The parameters received by the :php:`LocalizationController`

The event allows changes to:

* the columns
* the columns list

This allows third party code to read or manipulate the "columns manifest" that gets displayed in the
translation modal when a user has clicked the ``Translate`` button in the page module, by implementing a listener for the event.


API
---

.. rst-class:: dl-parameters

getColumns()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Returns a list of columns, indexed by column position number, value is label
   (either LLL: or hardcoded).

setColumns(array $columns)
   :sep:`|` :aspect:`Arguments:` `$columns` Array
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   Overwrite the list of columns - see getter for array structure.

getColumnList()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   List of integer column position numbers used in the BackendLayout.

setColumnList(array $columnList)
   :sep:`|` :aspect:`Arguments:` `$columnList` array
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Overwrite the list of integer column positions.

getBackendLayout()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Backend\View\BackendLayout\BackendLayout`
   :sep:`|`

   Returns the currently used backend layout.

getRecords()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Array of records which were used when building the original column
   manifest and column position numbers list.

getParameters()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   Request parameters passed to LocalizationController.



