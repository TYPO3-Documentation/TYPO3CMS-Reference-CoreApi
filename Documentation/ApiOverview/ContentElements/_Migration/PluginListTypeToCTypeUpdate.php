<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Upgrades;

// composer req linawolf/list-type-migration
use Linawolf\ListTypeMigration\Upgrades\AbstractListTypeToCTypeUpdate;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;

#[UpgradeWizard('myExtensionPluginListTypeToCTypeUpdate')]
final class PluginListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'my_extension_pi1' => 'my_extension_pi1',
            'my_extension_pi2' => 'my_extension_newpluginname',
        ];
    }

    public function getTitle(): string
    {
        return 'Migrates my_extension plugins';
    }

    public function getDescription(): string
    {
        return 'Migrates my_extension_pi1, my_extension_pi2 from list_type to CType.';
    }
}
