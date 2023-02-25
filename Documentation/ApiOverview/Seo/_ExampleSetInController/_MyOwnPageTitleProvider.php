<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

final class MyOwnPageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
