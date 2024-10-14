<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Blog;
use MyVendor\MyExtension\Domain\Repository\BlogRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BlogController extends ActionController
{
    public function __construct(protected readonly BlogRepository $blogRepository)
    {
        // Note: The repository is a standard extbase repository, nothing specific
        //       to this example.
    }

    public function listAction(): ResponseInterface
    {
        $this->view->assign('blog', $this->blogRepository->findAll());
        return $this->htmlResponse();
    }

    public function newAction(): ResponseInterface
    {
        // Create a fresh domain model for CRUD
        $this->view->assign('blog', GeneralUtility::makeInstance(Blog::class));
        return $this->htmlResponse();
    }

    public function createAction(Blog $blog): ResponseInterface
    {
        // Set some basic attributes to your domain model that users should not
        // influence themselves, like the storage PID
        $blog->setPid(42);

        // Persisting is needed to properly create FileReferences for the File object
        $this->blogRepository->add($blog);

        return $this->redirect('list');
    }

    public function editAction(?Blog $blog): ResponseInterface
    {
        $this->view->assign('blog', $blog);
        return $this->htmlResponse();
    }

    public function updateAction(Blog $item): ResponseInterface
    {
        $this->blogRepository->update($item);
        return $this->redirect('list');
    }
}
