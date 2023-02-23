<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent;

final class MyEventListener
{
    public function __invoke(ModifyPageLayoutContentEvent $event): void
    {
        $event->addHeaderContent('Additional header content');

        $event->setFooterContent('Overwrite footer content');
    }
}
