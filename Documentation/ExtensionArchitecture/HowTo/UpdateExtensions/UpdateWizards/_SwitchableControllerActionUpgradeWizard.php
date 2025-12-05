<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Upgrades;

use TYPO3\CMS\Core\Attribute\UpgradeWizard;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface;

#[UpgradeWizard('myExtension_switchableControllerActionUpgradeWizard')]
final class SwitchableControllerActionUpgradeWizard implements UpgradeWizardInterface
{
    private const TABLE = 'tt_content';
    private const PLUGIN = 'myextension_myplugin';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly FlexFormTools $flexFormTools,
    ) {}

    public function getTitle(): string
    {
        return 'Migrate MyExtension plugins';
    }

    public function getDescription(): string
    {
        return 'Migrate MyExtension plugins from switchable controller actions to specific plugins';
    }

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
                    [ // where
                        'uid' => (int)$row['uid'],
                    ],
                );
        }
        return $updated;
    }

    private function loadFlexForm(string $flexFormString): array
    {
        return $this->flexFormTools
            ->convertFlexFormContentToArray($flexFormString);
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);
        $queryBuilder->getRestrictions()->removeAll();
        return (bool)$queryBuilder
            ->count('uid')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq('list_type', $queryBuilder->createNamedParameter(self::PLUGIN)),
            )
            ->executeQuery()
            ->fetchOne();
    }

    /**
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [];
    }
}
