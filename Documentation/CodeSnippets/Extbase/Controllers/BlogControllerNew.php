<?php

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;

class BlogController extends AbstractController
{
    /**
     * Displays a form for creating a new blog
     */
    public function newAction(?Blog $newBlog = null): ResponseInterface
    {
        $this->view->assignMultiple([
            'newBlog' => $newBlog,
            'administrators' => $this->administratorRepository->findAll(),
        ]);
        return $this->htmlResponse();
    }
}
