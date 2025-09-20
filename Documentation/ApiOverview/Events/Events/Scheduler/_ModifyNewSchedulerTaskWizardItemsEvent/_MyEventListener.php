<?php

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Scheduler\Event\ModifyNewSchedulerTaskWizardItemsEvent;

final class ModifySchedulerTaskWizardListener
{
    #[AsEventListener('my-extension/scheduler/modify-wizard-items')]
    public function __invoke(ModifyNewSchedulerTaskWizardItemsEvent $event): void
    {
        // Add a custom task to the wizard
        $event->addWizardItem('my_custom_task', [
            'title' => 'My Custom Task',
            'description' => 'A custom task provided by my extension',
            'iconIdentifier' => 'my-custom-icon',
            'taskType' => 'MyVendor\\MyExtension\\Task\\CustomTask',
            'taskClass' => 'MyVendor\\MyExtension\\Task\\CustomTask',
        ]);

        // Remove an existing task
        $event->removeWizardItem('redirects_redirects:checkintegrity');

        // Modify existing wizard items
        $wizardItems = $event->getWizardItems();
        foreach ($wizardItems as $key => $item) {
            if (isset($item['title']) && str_contains($item['title'], 'referenceindex:update')) {
                $item['title'] = 'Update reference index';
                $event->addWizardItem($key, $item);
            }
        }
    }
}
