<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyNewContentElementWizardItemsEvent;

final class MyEventListener
{
    public function __invoke(ModifyNewContentElementWizardItemsEvent $event): void
    {
        // Add a new wizard item after "textpic"
        $event->setWizardItem(
            'my_element',
            [
                'iconIdentifier' => 'icon-my-element',
                'title' => 'My element',
                'description' => 'My element description',
                'tt_content_defValues' => [
                    'CType' => 'my_element',
                ],
            ],
            ['after' => 'common_textpic']
        );
    }
}
