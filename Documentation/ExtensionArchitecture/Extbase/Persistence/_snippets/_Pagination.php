<?php

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\ConferenceRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;

class ConferenceController extends ActionController
{
    public function __construct(
        protected readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function listAction(int $currentPage = 1): ResponseInterface
    {
        $conferences = $this->conferenceRepository->findAll();
        $paginator = new QueryResultPaginator($conferences, $currentPage, 10);
        $pagination = new SimplePagination($paginator);

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => $pagination,
        ]);
        return $this->htmlResponse();
    }
}
