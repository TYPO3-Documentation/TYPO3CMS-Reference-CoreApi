<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Model\Blog;
use MyVendor\MyExtension\Domain\Repository\BlogRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BlogController extends ActionController
{
    public function __construct(protected readonly BlogRepository $blogRepository)
    {
        // Note: The repository is a standard extbase repository, nothing specific
        //       to this example.
    }

    public function showAction(Blog $blog): ResponseInterface
    {
        $this->view->assign('blog', $blog);

        return $this->htmlResponse();
    }
}
