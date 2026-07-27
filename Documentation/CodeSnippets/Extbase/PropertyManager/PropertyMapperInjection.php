<?php

use T3docs\BlogExample\Domain\Repository\BlogRepository;
use T3docs\BlogExample\Domain\Repository\PersonRepository;
use T3docs\BlogExample\Domain\Repository\PostRepository;
use T3docs\BlogExample\PageTitle\BlogPageTitleProvider;
use TYPO3\CMS\Extbase\Property\PropertyMapper;

class PostController extends AbstractController
{
    /**
     * PostController constructor.
     *
     * Takes care of dependency injection
     */
    public function __construct(
        protected readonly BlogRepository $blogRepository,
        protected readonly PersonRepository $personRepository,
        protected readonly PostRepository $postRepository,
        protected readonly PropertyMapper $propertyMapper,
        protected readonly BlogPageTitleProvider $blogPageTitleProvider,
    ) {}
}
