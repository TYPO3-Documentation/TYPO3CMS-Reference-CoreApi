..  include:: /Includes.rst.txt
..  index:: Pagination
..  _pagination:

==========
Pagination
==========

The TYPO3 Core provides an interface to implement the native pagination of lists like arrays or
query results of Extbase.

The foundation of that new interface :php:`\TYPO3\CMS\Core\Pagination\PaginatorInterface` is that
it's type agnostic. It means, that it doesn't define the type of paginatable objects. It's up to the
concrete implementations to enable pagination for specific types. The interface only forces you to
reduce the incoming list of items to an :php:`iterable` sub set of items.

Along with that interface, an abstract paginator class :php:`\TYPO3\CMS\Core\Pagination\AbstractPaginator`
is available that implements the base pagination logic for any kind of :php:`Countable` set of
items while it leaves the processing of items to the concrete paginator class.

..  contents:: Table of Contents
    :depth: 2
    :local:


..  _pagination-paginators:

Paginators
==========

..  versionadded:: 14.2
    The :php-short:`\TYPO3\CMS\Core\Pagination\QueryBuilderPaginator` has been
    introduced.

Three concrete paginators are available:

*   For type :php:`array`: :php:`\TYPO3\CMS\Core\Pagination\ArrayPaginator`
*   For type :php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface`:
    :php:`\TYPO3\CMS\Extbase\Pagination\QueryResultPaginator`
*   For type :php:`\TYPO3\CMS\Core\Database\Query\QueryBuilder`:
    :php:`\TYPO3\CMS\Core\Pagination\QueryBuilderPaginator`


..  _pagination-example-array-paginator:

Example: `ArrayPaginator`
-------------------------

Code example for the :php:`ArrayPaginator` in an
:ref:`Extbase controller <extbase-controller-action>`:

..  literalinclude:: _ArrayPaginatorExampleController.php
    :caption: EXT:my_extension/Controller/ExampleController.php

And the corresponding Fluid template:

..  literalinclude:: _ArrayPaginatorExamplePagination.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ExamplePagination.fluid.html


..  _pagination-example-query-builder-paginator:

Example: `QueryBuilderPaginator`
--------------------------------

The paginated items are fetched only once per page request by storing the result
internally, avoiding double execution of the database statement.

The total item count is determined robustly using a common table expression
(CTE) wrapping the passed :ref:`QueryBuilder <database-query-builder>` instance.
This approach correctly handles advanced queries involving :sql:`UNION`, nested
CTEs, windowing functions, or grouping.

..  literalinclude:: _QueryBuilderPaginator.php
    :caption: EXT:my_extension/Controller/ExampleController.php

..  note::
    The :php-short:`\TYPO3\CMS\Core\Pagination\QueryBuilderPaginator` does
    **not** handle language overlays. Applying overlays on the result set can
    lead to unexpected item count differences between pages when some records
    are hidden after overlay processing. Use
    :php-short:`\TYPO3\CMS\Extbase\Pagination\QueryResultPaginator` or
    :php-short:`\TYPO3\CMS\Core\Pagination\ArrayPaginator` when language
    overlay handling is required.

    The paginator also takes **full control** over `LIMIT` and `OFFSET`
    and does not respect any existing limit/offset constraints on the passed
    :php:`QueryBuilder` instance.

..  _pagination-number-of-items:

Showing the number of items of a paginator
------------------------------------------

..  versionadded:: 14.3.11
    :changelog: important-106764-1790697600

Each paginator that extends
:php-short:`\TYPO3\CMS\Core\Pagination\AbstractPaginator`, which includes
all paginators of the TYPO3 Core, returns the number of its items:

*   :php-short:`\TYPO3\CMS\Core\Pagination\AbstractPaginator->getTotalNumberOfItems()`
    returns the number of all items, on all pages.
*   :php-short:`\TYPO3\CMS\Core\Pagination\AbstractPaginator->getNumberOfItemsOnCurrentPage()`
    returns the number of items on the current page.

The paginator has already counted the items, so the methods need no
additional query. In Fluid, read them as properties of the paginator:

..  literalinclude:: _NumberOfItems.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/ExamplePagination.fluid.html

A custom paginator that extends
:php-short:`\TYPO3\CMS\Core\Pagination\AbstractPaginator` gets both
methods. If it already has methods with these names, they must be public and
return an integer.


..  _pagination-sliding-window:

Sliding window pagination
=========================

The sliding window pagination can be used to paginate array items or query
results from Extbase. The main advantage is that it reduces the amount of pages
shown.

**Example**: Imagine 1000 records and 20 items per page which would lead to
50 links. Using the `SlidingWindowPagination`, you will get something like
this `< prev ... 21 22 23 24 ... next >` or `< 1 ... 21 22 23 24 ... 50 >` or
simple `< 21 22 23 24 >`. Customize the template to suit your needs.


..  _pagination-sliding-window-usage:

Usage
-----

Replace the usage of :php:`SimplePagination` with
:php:`\TYPO3\CMS\Core\Pagination\SlidingWindowPagination` and you are done. Set
the 2nd argument to the maximum number of links which should be rendered.

..  literalinclude:: _SlidingWindowExampleController.php
    :caption: EXT:my_extension/Controller/ExampleController.php
