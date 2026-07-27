<?php

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;

class BlogController extends AbstractController
{
    public function showBlogAjaxAction(Blog $blog): ResponseInterface
    {
        $jsonOutput = json_encode($blog);
        return $this->jsonResponse($jsonOutput);
    }
}
