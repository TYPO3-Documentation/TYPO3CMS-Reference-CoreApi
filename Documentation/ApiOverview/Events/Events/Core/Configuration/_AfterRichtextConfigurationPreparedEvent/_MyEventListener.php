<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Configuration\EventListener;

use TYPO3\CMS\Core\Configuration\Event\AfterRichtextConfigurationPreparedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class EnableDebugRichTextEditorEventListener
{
    #[AsEventListener('my-package/configuration/modify-richtext-configuration')]
    public function __invoke(AfterRichtextConfigurationPreparedEvent $event): void
    {
        $config = $event->getConfiguration();
        $config['editor']['config']['debug'] = true;
        $event->setConfiguration($config);
    }
}
