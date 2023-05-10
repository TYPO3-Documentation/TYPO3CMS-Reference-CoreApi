<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\TypoScript\EventListener;

use TYPO3\CMS\Core\TypoScript\IncludeTree\Event\AfterTemplatesHaveBeenDeterminedEvent;

final class MyEventListener
{
    public function __invoke(AfterTemplatesHaveBeenDeterminedEvent $event): void
    {
        $rows = $event->getTemplateRows();

        // ... do something ...

        $event->setTemplateRows($rows);
    }
}
