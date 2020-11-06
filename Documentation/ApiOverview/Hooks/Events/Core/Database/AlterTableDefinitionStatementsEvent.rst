.. include:: /Includes.rst.txt


.. _AlterTableDefinitionStatementsEvent:


===================================
AlterTableDefinitionStatementsEvent
===================================

Event to intercept the "CREATE TABLE" statement from all loaded extensions.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:


.. rst-class:: dl-parameters

addSqlData(string $data)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

getSqlData()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

setSqlData(array $sqlData)
   :sep:`|` :aspect:`ReturnType:` void
   :sep:`|`

   |nbsp|

