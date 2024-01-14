..  include:: /Includes.rst.txt
..  index:: Events; ModifyDefaultConstraintsForDatabaseQueryEvent
..  _ModifyDefaultConstraintsForDatabaseQueryEvent:

=============================================
ModifyDefaultConstraintsForDatabaseQueryEvent
=============================================

..  versionadded:: 13.0
    This event serves as a replacement for the removed hook
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_page.php']['addEnableColumns']`.

The API class :php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository` has a
method :php:`getDefaultConstraints()` which accumulates common 
restrictions for a database query. The purpose is to limit queries for 
TCA-based tables, filtering out disabled or scheduled records.

The PSR-14 event
:php:`\TYPO3\CMS\Core\Domain\Event\ModifyDefaultConstraintsForDatabaseQueryEvent`
allows to remove, alter or add constraints compiled by TYPO3 for a specific
table to further limit these constraints.

The event contains a list of :php:`CompositeExpression` objects, allowing
to modify them via the :php:`getConstraints()` and
:php:`setConstraints(array $constraints)` methods.

Example
=======

..  include:: /_includes/EventsContributeNote.rst.txt

API
===

..  include:: /CodeSnippets/Events/Core/ModifyDefaultConstraintsForDatabaseQueryEvent.rst.txt
