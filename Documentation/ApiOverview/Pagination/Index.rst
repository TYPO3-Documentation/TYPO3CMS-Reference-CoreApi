.. include:: /Includes.rst.txt
.. index:: Pagination
.. _pagination:

==========
Pagination
==========

.. note::

   Pagination via Fluid widgets was removed, see
   :doc:`t3core:Changelog/11.0/Breaking-92529-AllFluidWidgetFunctionalityRemoved`.
   Use the API documented here to implement your own pagination.

The TYPO3 Core provides an interface to implement the native pagination of lists like arrays or
query results of Extbase.

The foundation of that new interface :php:`\TYPO3\CMS\Core\Pagination\PaginatorInterface` is that
it's type agnostic. It means, that it doesn't define the type of paginatable objects. It's up to the
concrete implementations to enable pagination for specific types. The interface only forces you to
reduce the incoming list of items to an :php:`iterable` sub set of items.

Along with that interface, an abstract paginator class :php:`\TYPO3\CMS\Core\Pagination\AbstractPaginator`
is available that implements the base pagination logic for any kind of :php:`Countable` set of
items while it leaves the processing of items to the concrete paginator class.

Two concrete paginators are available. One for :php:`array` and one for
:php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface` objects.

Code-Example for the :php:`ArrayPaginator`:

.. code-block:: php

   // use TYPO3\CMS\Core\Pagination\ArrayPaginator;

   $itemsToBePaginated = ['apple', 'banana', 'strawberry', 'raspberry', 'pineapple'];
   $itemsPerPage = 2;
   $currentPageNumber = 3;

   $paginator = new ArrayPaginator($itemsToBePaginated, $currentPageNumber, $itemsPerPage);
   $paginator->getNumberOfPages(); // returns 3
   $paginator->getCurrentPageNumber(); // returns 3, basically just returns the input value
   $paginator->getKeyOfFirstPaginatedItem(); // returns 5
   $paginator->getKeyOfLastPaginatedItem(); // returns 5
   $paginator->getAllPageNumbers(); // returns [1,2,3]

