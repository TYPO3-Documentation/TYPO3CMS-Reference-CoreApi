..  include:: /Includes.rst.txt
..  index:: Events; AlterTableDefinitionStatementsEvent
..  _AlterTableDefinitionStatementsEvent:

===================================
AlterTableDefinitionStatementsEvent
===================================

The PSR-14 event
:php:`\TYPO3\CMS\Core\Database\Event\AlterTableDefinitionStatementsEvent`
allows to intercept the :sql:`CREATE TABLE` statement from all loaded
extensions.

API
===

..  include:: /CodeSnippets/Events/Core/AlterTableDefinitionStatementsEvent.rst.txt
