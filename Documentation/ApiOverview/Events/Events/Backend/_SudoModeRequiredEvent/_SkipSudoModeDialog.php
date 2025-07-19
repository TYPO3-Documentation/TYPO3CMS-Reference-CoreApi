<?php
declare(strict_types=1);

namespace Vendor\MyExtension\EventListener;

use TYPO3\CMS\Backend\Hooks\DataHandlerAuthenticationContext;
use TYPO3\CMS\Backend\Security\SudoMode\Access\AccessSubjectInterface;
use TYPO3\CMS\Backend\Security\SudoMode\Access\TableAccessSubject;
use TYPO3\CMS\Backend\Security\SudoMode\Event\SudoModeRequiredEvent;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

final class SkipSudoModeDialog
{
    public function __invoke(SudoModeRequiredEvent $event): void
    {
        // Ensure the event context matches DataHandler operations
        if ($event->getClaim()->origin !== DataHandlerAuthenticationContext::class) {
            return;
        }

        // Filter for TableAccessSubject types only
        $tableAccessSubjects = array_filter(
            $event->getClaim()->subjects,
            static fn (AccessSubjectInterface $subject): bool => $subject instanceof TableAccessSubject
        );

        // Abort if there are unhandled subject types
        if ($event->getClaim()->subjects !== $tableAccessSubjects) {
            return;
        }

        /** @var list<TableAccessSubject> $tableAccessSubjects */
        foreach ($tableAccessSubjects as $subject) {
            // Expecting format: tableName.fieldName.id
            if (substr_count($subject->getSubject(), '.') !== 2) {
                return;
            }

            [$tableName, $fieldName, $id] = explode('.', $subject->getSubject());

            // Only handle be_users table
            if ($tableName !== 'be_users') {
                return;
            }

            // Skip if ID is not a valid integer (e.g., 'NEW' records)
            if (!MathUtility::canBeInterpretedAsInteger($id)) {
                continue;
            }

            $record = BackendUtility::getRecord($tableName, $id);

            // Abort if any record does not use SSO
            if (empty($record['is_sso'])) {
                return;
            }
        }

        // All conditions met — disable verification
        $event->setVerificationRequired(false);
    }
}
