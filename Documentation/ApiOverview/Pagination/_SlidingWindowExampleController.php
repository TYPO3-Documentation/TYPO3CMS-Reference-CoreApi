<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ExampleRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

final class ExampleController extends ActionController
{
    public function __construct(
        private readonly ExampleRepository $exampleRepository,
    ) {}

    public function myAction(): ResponseInterface
    {
        $allItems = $this->exampleRepository->findAll();

        $currentPage = $this->request->hasArgument('currentPageNumber')
            ? (int)$this->request->getArgument('currentPageNumber')
            : 1;
        $itemsPerPage = 10;
        $maximumLinks = 15;

        $paginator = new QueryResultPaginator(
            $allItems,
            $currentPage,
            $itemsPerPage,
        );
        $pagination = new SlidingWindowPagination(
            $paginator,
            $maximumLinks,
        );

        // ... more logic ...

        $this->view->assign('pagination', $pagination);

        return $this->htmlResponse();
    }
}
