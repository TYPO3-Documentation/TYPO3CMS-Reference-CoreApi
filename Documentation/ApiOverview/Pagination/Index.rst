.. include:: /Includes.rst.txt
.. index:: Pagination
.. _pagination:

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

Two concrete paginators are available:

*  For type :php:`array`: :php:`\TYPO3\CMS\Core\Pagination\ArrayPaginator`
*  For type :php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface`:
   :php:`\TYPO3\CMS\Extbase\Pagination\QueryResultPaginator`

Code example for the :php:`ArrayPaginator` in an
:ref:`Extbase controller <extbase-action-controller>`:

..  literalinclude:: _ArrayPaginatorExampleController.php
    :caption: EXT:my_extension/Controller/ExampleController.php

And the corresponding Fluid template:

..  literalinclude:: _ArrayPaginatorExamplePagination.html
    :caption: EXT:my_extension/Resources/Private/Templates/ExamplePagination.html


Sliding window pagination
=========================

The sliding window pagination can be used to paginate array items or query
results from Extbase. The main advantage is that it reduces the amount of pages
shown.

**Example**: Imagine 1000 records and 20 items per page which would lead to
50 links. Using the `SlidingWindowPagination`, you will get something like
this `< prev ... 21 22 23 24 ... next >` or `< 1 ... 21 22 23 24 ... 50 >` or
simple `< 21 22 23 24 >`. Customise the template to suit your needs.

Usage
-----

Replace the usage of :php:`SimplePagination` with
:php:`\TYPO3\CMS\Core\Pagination\SlidingWindowPagination` and you are done. Set
the 2nd argument to the maximum number of links which should be rendered.

..  literalinclude:: _SlidingWindowExampleController.php
    :caption: EXT:my_extension/Controller/ExampleController.php
