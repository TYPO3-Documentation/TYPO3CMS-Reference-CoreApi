<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Pagination\QueryBuilderPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;

$paginator = new QueryBuilderPaginator(
    queryBuilder: $queryBuilder,
    currentPageNumber: $currentPage,
    itemsPerPage: 10,
);
$pagination = new SimplePagination($paginator);

// Retrieve the items for the current page
$items = $paginator->getPaginatedItems();
