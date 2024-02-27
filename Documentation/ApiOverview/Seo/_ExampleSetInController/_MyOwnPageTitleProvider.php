<?php

declare(strict_types=1);

namespace MyVendor\MySitepackage\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

final class MyOwnPageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
