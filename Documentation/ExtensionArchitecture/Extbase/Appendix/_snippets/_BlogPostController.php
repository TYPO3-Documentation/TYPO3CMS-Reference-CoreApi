<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use MyVendor\MyExtension\Domain\Repository\BlogPostRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BlogPostController extends ActionController
{
  public function __construct(
    protected readonly BlogPostRepository $blogPostRepository,
  ) {}
}
