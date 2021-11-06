.. include:: /Includes.rst.txt
.. index:: Events; ModifyRecordListHeaderColumnsEvent
.. _ModifyRecordListHeaderColumnsEvent:


========================================
ModifyRecordListHeaderColumnsEvent
========================================

.. versionadded:: 11.4

An event to modify the header columns for a table in the record list.

API
===

.. php:namespace:: TYPO3\CMS\Recordlist\Event\

.. php:class:: ModifyRecordListHeaderColumnsEvent

   .. php:method:: setColumn(string $column, string $columnName = '')

      Add a new column or override an existing one. Latter is only possible,
      in case $columnName is given. Otherwise, the column will be added with
      a numeric index, which is generally not recommended.

      .. note::
         Due to the behaviour of DatabaseRecordList, just adding a column
         does not mean that it is also displayed. The internal $fieldArray needs
         to be adjusted as well. This method only adds the column to the data array.
         Therefore, this method should mainly be used to edit existing columns.

      :param string $action: The column to be set
      :param string $actionName: Recommended: the name of the column
      :returntype: void


   .. php:method:: hasColumn(string $columnName)

      Whether the column exists

      :param string $columnName: The name of the column
      :returntype: bool

   .. php:method:: getColumn(string $columnName)

      Get column by its name

      :param string $columnName: The name of the column
      :returntype: string|null
      :returns: The action or NULL if the column does not exist

   .. php:method:: removeColumn(string $columnName)

      Remove column by its name

      :param string $columnName: The name of the column
      :returntype: bool
      :returns: Whether the column could be removed - Will therefore return
         FALSE if the column to remove does not exist.

   .. php:method:: setColumns(array $columns)

      :param array $columns: An array of string, each represents a columns
      :returntype: void

   .. php:method:: getColumns()

      :returntype: array

   .. php:method:: setHeaderAttributes(array $headerAttributes)

      :param array $headerAttributes: An array of string, each represents a header attribute
      :returntype: void

   .. php:method:: getHeaderAttributes()

      :returntype: array

   .. php:method:: getTable()

      :returntype: string

   .. php:method:: getRecordIds()

      :returntype: array

   .. php:method:: getRecordList()

      Returns the current DatabaseRecordList instance.

      :returntype: DatabaseRecordList


Usage
=====

See :ref:`combined usage example <ModifyRecordListTableActionsEvent-usage>`.
