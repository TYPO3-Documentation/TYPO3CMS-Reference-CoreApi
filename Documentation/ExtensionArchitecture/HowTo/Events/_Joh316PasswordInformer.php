<?php

// EXT:my_extension/Classes/EventListener/Joh316PasswordInformer.php
declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent;

/**
 * The password 'joh316' was historically used as the default password for
 * the TYPO3 install tool.
 * Today this password is an unsecure choice as it is well-known, too short
 * and does not contain capital letters or special characters.
 */
#[AsEventListener]
final class Joh316PasswordInvalidator
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    public function __invoke(PasswordChangeEvent $event): void
    {
        if ($event->getRawPassword() === 'joh316') {
            $this->logger->warning(sprintf(
                'User %s uses the default password "joh316".',
                $event->getUser()['username'],
            ));
        }
    }
}
