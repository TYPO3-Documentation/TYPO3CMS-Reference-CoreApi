<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Lowlevel\EventListener;

use TYPO3\CMS\Lowlevel\Event\ModifyBlindedConfigurationOptionsEvent;

final class MyEventListener
{
    public function __invoke(ModifyBlindedConfigurationOptionsEvent $event): void
    {
        $options = $event->getBlindedConfigurationOptions();

        if ($event->getProviderIdentifier() === 'sitesYamlConfiguration') {
            $options['my-site']['settings']['apiKey'] = '***';
        } elseif ($event->getProviderIdentifier() === 'confVars') {
            $options['TYPO3_CONF_VARS']['EXTENSIONS']['my_extension']['password'] = '***';
        }

        $event->setBlindedConfigurationOptions($options);
    }
}
