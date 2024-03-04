<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Workspaces\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Utility\DiffUtility;
use TYPO3\CMS\Workspaces\Event\ModifyVersionDifferencesEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-version-differences',
)]
final readonly class MyEventListener
{
    public function __construct(private readonly DiffUtility $diffUtility)
    {
        $this->diffUtility->stripTags = false;
    }

    public function __invoke(ModifyVersionDifferencesEvent $event): void
    {
        $differences = $event->getVersionDifferences();
        foreach ($differences as $key => $difference) {
            if ($difference['field'] === 'my_test_field') {
                $differences[$key]['content'] = $this->diffUtility->makeDiffDisplay('a', 'b');
            }
        }

        $event->setVersionDifferences($differences);
    }
}
