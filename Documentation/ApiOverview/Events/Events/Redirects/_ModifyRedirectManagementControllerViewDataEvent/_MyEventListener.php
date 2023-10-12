<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Redirects\Event\ModifyRedirectManagementControllerViewDataEvent;

#[AsEventListener(
    identifier: 'my-extension/modify-redirect-management-controller-view-data'
)]
final class MyEventListener
{
    public function __invoke(ModifyRedirectManagementControllerViewDataEvent $event): void
    {
        $hosts = $event->getHosts();

        // Remove wildcard host from list
        $hosts = array_filter($hosts, static fn($host) => $host['name'] !== '*');

        // Ipdate changed hosts list
        $event->setHosts($hosts);
    }
}
