<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\BlogRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class PostController extends ActionController
{
    public function __construct(BlogRepository $blogRepository) {}

    public function displayRssListAction(): ResponseInterface
    {
        $defaultBlog = $this->settings['defaultBlog'] ?? 0;
        if ($defaultBlog > 0) {
            $blog = $this->blogRepository->findByUid((int)$defaultBlog);
        } else {
            $blog = $this->blogRepository->findAll()->getFirst();
        }
        $this->view->assign('blog', $blog);
        return $this->responseFactory->createResponse()
            ->withHeader('Content-Type', 'text/xml; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
