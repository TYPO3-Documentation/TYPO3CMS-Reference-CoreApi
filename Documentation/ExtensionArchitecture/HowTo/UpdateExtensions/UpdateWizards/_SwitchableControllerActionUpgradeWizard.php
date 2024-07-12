<?php

namespace MyVendor\MyExtension\Upgrades;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('myExtension_switchableControllerActionUpgradeWizard')]
final class SwitchableControllerActionUpgradeWizard implements UpgradeWizardInterface
{
    private const TABLE = 'tt_content';
    private const PLUGIN = 'myextension_myplugin';
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly FlexFormService $flexFormService,
    ) {}

    public function executeUpdate(): bool
    {
        $result = 0;
        $result += $this->migratePlugin(self::PLUGIN, 'MyController->list', 'myextension_mycontrollerlist');
        $result += $this->migratePlugin(self::PLUGIN, 'MyController->overview;MyController->detail', 'myextension_mycontrolleroverviewdetail');
        return $result > 0;
    }

    private function migratePlugin(string $plugin, string $switchable, string $newCType): int
    {
        $updated = 0;
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);
        $result = $queryBuilder
            ->select('*')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq('list_type', $queryBuilder->createNamedParameter($plugin)),
            )
            ->executeQuery();
        while ($row = $result->fetchAssociative()) {
            if (!is_string($row['pi_flexform'] ?? false)) {
                continue;
            }
            $flexform = $this->loadFlexForm($row['pi_flexform']);
            if (!isset($flexform['switchableControllerActions']) || $flexform['switchableControllerActions'] !== $switchable) {
                continue;
            }
            $updated++;
            $this->connectionPool->getConnectionForTable('tt_content')
                ->update(
                    self::TABLE,
                    [ // set
                        'CType' => $newCType,
                        'list_type' => '',
                    ],
                    [ 'uid' => (int)$row['uid'] ], // where
                );
        }
        return $updated;
    }
    private function loadFlexForm(string $flexFormString): array
    {
        return $this->flexFormService
            ->convertFlexFormContentToArray($flexFormString);
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);
        $queryBuilder
            ->count('uid')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq('list_type', self::PLUGIN),
            )
            ->executeQuery()
            ->fetchOne();
        return true;
    }

    public function getTitle(): string
    {
        return 'Migrate MyExtension plugins';
    }

    public function getDescription(): string
    {
        return 'Migrate MyExtension plugins from switchable controller actions to specific plugins';
    }

    /**
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [];
    }
}
