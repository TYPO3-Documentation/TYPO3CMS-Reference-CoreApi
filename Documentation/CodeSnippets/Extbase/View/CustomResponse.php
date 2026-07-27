<?php

use Psr\Http\Message\ResponseInterface;

class PostController extends AbstractController
{
    /**
     * Displays a list of posts as RSS feed
     */
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
