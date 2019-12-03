.. include:: ../../../../../../Includes.txt


.. _AlterTableDefinitionStatementsEvent:


===================================
AlterTableDefinitionStatementsEvent
===================================

Event to intercept the "CREATE TABLE" statement from all loaded extensions.

API
---


 - :Method:
         addSqlData(string $data)
   :Description:
         Add SQL statements to be executed.
   :ReturnType:
         void


 - :Method:
         getSqlData()
   :Description:
         Returns an array of statements to be executed.
   :ReturnType:
         array


 - :Method:
         setSqlData(array $sqlData)
   :Description:
         Set / Overwrite SQL statements array to be executed.
   :ReturnType:
         void

