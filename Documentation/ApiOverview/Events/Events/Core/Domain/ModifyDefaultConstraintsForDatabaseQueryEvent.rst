..  include:: /Includes.rst.txt
..  index:: Events; ModifyDefaultConstraintsForDatabaseQueryEvent
..  _ModifyDefaultConstraintsForDatabaseQueryEvent:

===============================================
`ModifyDefaultConstraintsForDatabaseQueryEvent`
===============================================

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

..  _modify-default-constraints-for-database-query-event-example:

Example: Restrict queries using a custom `enablecolumns` entry
==============================================================

The following example adds an additional restriction based on a custom TCA
`enablecolumns` entry. Assume a table stores a "purchased amount" range
per record (`purchased_amount_from` / `purchased_amount_to`), and
only records whose range contains the current customer's purchased amount
should be selected — for every query TYPO3 builds for that table, without
having to repeat the condition manually.

Declare the custom `enablecolumns` entry in the table's TCA:

..  literalinclude:: _ModifyDefaultConstraintsForDatabaseQueryEvent/_tca.php
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_domain_model_product.php

Add a listener that turns this into a query constraint whenever the event
fires for that table:

..  literalinclude:: _ModifyDefaultConstraintsForDatabaseQueryEvent/_PurchasedAmountRestrictionListener.php
    :caption: EXT:my_extension/Classes/EventListener/PurchasedAmountRestrictionListener.php

..  _modify-default-constraints-for-database-query-event-api:

API
===

..  include:: /CodeSnippets/Events/Core/ModifyDefaultConstraintsForDatabaseQueryEvent.rst.txt
