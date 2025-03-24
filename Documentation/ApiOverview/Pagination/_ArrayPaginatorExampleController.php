<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class ExampleController extends ActionController
{
    public function myAction(): ResponseInterface
    {
        // For better demonstration we create fixed items, in real
        // world usage a list of models is used instead.
        $itemsToBePaginated = ['apple', 'banana', 'strawberry', 'raspberry', 'pineapple'];
        $itemsPerPage = 2;
        $currentPageNumber = 3;

        $paginator = new ArrayPaginator($itemsToBePaginated, $currentPageNumber, $itemsPerPage);
        $paginator->getNumberOfPages(); // returns 3
        $paginator->getCurrentPageNumber(); // returns 3, basically just returns the input value
        $paginator->getKeyOfFirstPaginatedItem(); // returns 4
        $paginator->getKeyOfLastPaginatedItem(); // returns 4

        $pagination = new SimplePagination($paginator);
        $pagination->getAllPageNumbers(); // returns [1, 2, 3]
        $pagination->getPreviousPageNumber(); // returns 2
        $pagination->getNextPageNumber(); // returns null

        // ... more logic ...

        $this->view->assign('pagination', $pagination);

        return $this->htmlResponse();
    }
}
