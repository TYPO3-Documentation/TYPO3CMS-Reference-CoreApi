.. include:: /Includes.rst.txt
.. index:: Pagination
.. _pagination:

==========
Pagination
==========

.. note::

   Pagination via Fluid widgets was removed, see
   :doc:`ext_core:Changelog/11.0/Breaking-92529-AllFluidWidgetFunctionalityRemoved`.
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

Two concrete paginators are available:

*  For type :php:`array`: :php:`\TYPO3\CMS\Core\Pagination\ArrayPaginator`
*  For type :php:`\TYPO3\CMS\Extbase\Persistence\QueryResultInterface`:
   :php:`\TYPO3\CMS\Extbase\Pagination\QueryResultPaginator`

Code example for the :php:`ArrayPaginator`:

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

   // use TYPO3\CMS\Core\Pagination\SimplePagination;

   $pagination = new SimplePagination($paginator);
   $pagination->getAllPageNumbers(); // returns [1, 2, 3]
   $pagination->getPreviousPageNumber(); // returns 2
   $pagination->getNextPageNumber(); // returns null
   // …

.. code-block:: html

   <ul class="pagination">
      <f:for each="{pagination.allPageNumbers}" as="page">
         <li class="page-item">
            <f:link.action arguments="{currentPageNumber:page}"
                           class="page-link {f:if(condition:'{currentPageNumber}=={page}',then:'active')}">
               {page}
            </f:link.action>
         </li>
      </f:for>
   </ul>

   <f:for each="{paginator.paginatedItems}" as="item">
       {item}
   </f:for>

Sliding window pagination
=========================

.. versionadded:: 12.0

The sliding window pagination can be used to paginate array items or query
results from Extbase. The main advantage is that it reduces the amount of pages
shown.

**Example**: Imagine 1000 records and 20 items per page which would lead to
50 links. Using the `SlidingWindowPagination`, you will get something like
`< 1 2 ... 21 22 23 24 ... 100 >`.

Usage
-----

Replace the usage of :php:`SimplePagination` with
:php:`\TYPO3\CMS\Core\Pagination\SlidingWindowPagination` and you are done. Set
the 2nd argument to the maximum number of links which should be rendered.

.. code-block:: php

   // use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
   // use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;

   $currentPage = $this->request->hasArgument('currentPage')
       ? (int)$this->request->getArgument('currentPage')
       : 1;
   $itemsPerPage = 10;
   $maximumLinks = 15;

   $paginator = new QueryResultPaginator(
       $allItems,
       $currentPage,
       $itemsPerPage
   );
   $pagination = new SlidingWindowPagination(
       $paginator,
       $maximumLinks
   );

   $this->view->assign(
       'pagination',
       [
           'pagination' => $pagination,
           'paginator' => $paginator,
       ]
   );
