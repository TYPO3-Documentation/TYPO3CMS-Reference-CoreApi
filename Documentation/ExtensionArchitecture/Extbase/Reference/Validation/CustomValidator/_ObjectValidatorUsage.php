<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Controller;

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Validator\BlogValidator;
use T3docs\BlogExample\Exception\NoBlogAdminAccessException;
use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BlogController extends ActionController
{
    /**
     * Updates an existing blog
     *
     * $blog is a not yet persisted clone of the original blog containing
     * the modifications
     *
     * @throws NoBlogAdminAccessException
     */
    public function updateAction(
        #[Validate([
            'validator' => BlogValidator::class,
        ])]
        Blog $blog,
    ): ResponseInterface {
        // do something
        return $this->htmlResponse();
    }
}
