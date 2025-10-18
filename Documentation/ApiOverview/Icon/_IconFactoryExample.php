<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;

final class MyClass
{
    public function __construct(
        private readonly IconFactory $iconFactory,
    ) {}

    public function doSomething()
    {
        $icon = $this->iconFactory->getIcon(
            'tx-myextension-action-preview',
            IconSize::SMALL,
            'overlay-identifier',
        );

        // Do something with the icon, for example, assign it to the view
        // $this->view->assign('icon', $icon);
    }
}
