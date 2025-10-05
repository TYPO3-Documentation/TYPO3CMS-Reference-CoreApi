<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Controller;

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class BlogController extends ActionController
{
    #[IgnoreValidation(['argumentName' => 'blog'])]
    public function editAction(Blog $blog): ResponseInterface
    {
        // Do something
        $this->view->assign('blog', $blog);
        return $this->htmlResponse();
    }
}
