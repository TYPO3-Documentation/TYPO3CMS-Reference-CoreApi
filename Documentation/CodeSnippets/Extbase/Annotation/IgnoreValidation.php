<?php

use Psr\Http\Message\ResponseInterface;
use T3docs\BlogExample\Domain\Model\Blog;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;

class BlogController extends AbstractController
{
    /**
     * Displays a form for editing an existing blog
     *
     * @IgnoreValidation("blog")
     */
    public function editAction(Blog $blog): ResponseInterface
    {
        $this->view->assign('blog', $blog);
        $this->view->assign(
            'administrators',
            $this->administratorRepository->findAll(),
        );
        return $this->htmlResponse();
    }
}
