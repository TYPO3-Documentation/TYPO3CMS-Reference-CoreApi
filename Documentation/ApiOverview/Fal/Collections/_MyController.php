<?php

declare(strict_types=1);

namespace Collections;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\FileCollectionRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class MyController extends ActionController
{
    public function __construct(
        private readonly FileCollectionRepository $collectionRepository,
    ) {}

    /**
     * Renders the list of all existing collections and their content
     */
    public function listAction(): ResponseInterface
    {
        // Get all existing collections
        $collections = $this->collectionRepository->findAll() ?? [];

        // Load the records in each collection
        foreach ($collections as $aCollection) {
            $aCollection->loadContents();
        }

        // Assign the "loaded" collections to the view
        $this->view->assign('collections', $collections);

        return $this->htmlResponse();
    }
}
