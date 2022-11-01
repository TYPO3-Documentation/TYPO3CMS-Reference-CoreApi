<?php

declare(strict_types=1);
namespace T3docs\BlogExample\Controller;

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class BlogController extends ActionController
{
    #[IgnoreValidation('newBlog')]
    public function newAction(?Blog $newBlog = null): ResponseInterface
    {
        // Do something
        return $this->htmlResponse();
    }

    /**
     * Use annotations instead for compatibility with TYPO3 v11 and PHP 7.4:
     * @IgnoreValidation("newBlog")
     */
    public function newAction2(?Blog $newBlog = null): ResponseInterface
    {
        // Do something
        return $this->htmlResponse();
    }
}
