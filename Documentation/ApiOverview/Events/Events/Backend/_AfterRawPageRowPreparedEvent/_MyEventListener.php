<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Tree\Repository\AfterRawPageRowPreparedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class MyEventListener
{
    #[AsEventListener]
    public function __invoke(AfterRawPageRowPreparedEvent $event): void
    {
        $rawPage = $event->getRawPage();
        if ((int)$rawPage['uid'] === 123) {
            // Sort pages alphabetically in the page tree
            $rawPage['_children'] = usort(
                $rawPage['__children'],
                static fn(array $a, array $b) => strcmp($a['title'], $b['title']),
            );
            $rawPage['title'] = 'Some special title';
            $event->setRawPage($rawPage);
        }
    }
}
