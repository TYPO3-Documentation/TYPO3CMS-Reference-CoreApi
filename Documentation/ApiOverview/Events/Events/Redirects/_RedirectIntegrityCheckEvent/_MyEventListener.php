<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Redirects\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Redirects\Event\RedirectIntegrityCheckEvent;
use TYPO3\CMS\Redirects\Utility\RedirectConflict;

final readonly class MyEventListener
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    #[AsEventListener('my-extension/validate-redirect-target')]
    public function __invoke(RedirectIntegrityCheckEvent $event): void
    {
        $target = $event->getTarget();
        if (!str_starts_with($target, 't3://record')) {
            return;
        }
        // Parse t3://record?identifier=tx_news&uid=456
        parse_str((string)parse_url($target, PHP_URL_QUERY), $params);
        $table = $params['identifier'] ?? '';
        $uid = (int)($params['uid'] ?? 0);
        if ($table === '' || $uid === 0) {
            $event->setIntegrityStatus(RedirectConflict::INVALID_TARGET);
            return;
        }
        $count = $this->connectionPool
            ->getConnectionForTable($table)
            ->count('uid', $table, ['uid' => $uid]);
        if ($count === 0) {
            $event->setIntegrityStatus(RedirectConflict::INVALID_TARGET);
            return;
        }
        // Set to NO_CONFLICT - will not be reported as conflicting redirect
        // but will clear out already other integrity status.
        $event->setIntegrityStatus(RedirectConflict::NO_CONFLICT);
    }
}
