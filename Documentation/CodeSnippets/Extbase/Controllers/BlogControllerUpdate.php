<?php

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Exception\NoBlogAdminAccessException;

class BlogController extends AbstractController
{
    /**
     * Updates an existing blog
     *
     * $blog is a not yet persisted clone of the original blog containing
     * the modifications
     *
     * @throws NoBlogAdminAccessException
     */
    public function updateAction(Blog $blog): ResponseInterface
    {
        $this->checkBlogAdminAccess();
        $this->blogRepository->update($blog);
        $this->addFlashMessage('updated');
        return $this->redirect('index');
    }
}
