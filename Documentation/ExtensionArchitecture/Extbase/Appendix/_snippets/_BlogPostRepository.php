<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BlogPostRepository extends Repository
{
  protected $defaultOrderings = [
    'publishDate' => QueryInterface::ORDER_ASCENDING,
  ];
}
