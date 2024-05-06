<?php

declare(strict_types=1);

namespace Vendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\FrontendLogin\Event\ModifyRedirectUrlValidationResultEvent;

final class ValidateRedirectUrl
{
    public const TRUSTED_HOST_FOR_REDIRECT = 'example.org';

    #[AsEventListener('validate-custom-redirect-url')]
    public function __invoke(ModifyRedirectUrlValidationResultEvent $event): void
    {
        $parsedUrl = parse_url($event->getRedirectUrl());
        if ($parsedUrl['host'] === self::TRUSTED_HOST_FOR_REDIRECT) {
            $event->setValidationResult(true);
        }
    }
}
