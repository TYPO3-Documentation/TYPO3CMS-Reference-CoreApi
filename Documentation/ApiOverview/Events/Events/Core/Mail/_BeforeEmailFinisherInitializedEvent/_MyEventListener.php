<?php

declare(strict_types=1);

namespace Vendor\MyPackage\Form\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Form\Event\BeforeEmailFinisherInitializedEvent;

final class BeforeEmailFinisherInitializedEventListener
{
    #[AsEventListener('my-package/form/modify-email-finisher-options')]
    public function __invoke(BeforeEmailFinisherInitializedEvent $event): void
    {
        $options = $event->getOptions();
        $context = $event->getFinisherContext();

        // Overwrite recipients based on FormContext
        if ($context->getFormRuntime()->getFormDefinition()->getIdentifier() === 'my-form-123') {
            $options['recipients'] = ['user@example.org' => 'John Doe'];
        }

        // Modify subject dynamically
        $options['subject'] = 'Custom subject: ' . ($options['subject'] ?? '');

        // Clear CC and BCC recipients
        $options['replyToRecipients'] = [];
        $options['blindCarbonCopyRecipients'] = [];

        $event->setOptions($options);
    }
}
