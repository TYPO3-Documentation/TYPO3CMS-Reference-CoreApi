<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Upgrades;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('myExtension_exampleUpgradeWizard')]
final class ExampleUpgradeWizard implements UpgradeWizardInterface
{
    /**
     * Return the speaking name of this wizard
     */
    public function getTitle(): string
    {
        return 'Title of this updater';
    }

    /**
     * Return the description for this wizard
     */
    public function getDescription(): string
    {
        return 'Description of this updater';
    }

    /**
     * Execute the update
     *
     * Called when a wizard reports that an update is necessary
     */
    public function executeUpdate(): bool
    {
        // Add your logic here
    }

    /**
     * Is an update necessary?
     *
     * Is used to determine whether a wizard needs to be run.
     * Check if data for migration exists.
     *
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    public function updateNecessary(): bool
    {
        // Add your logic here
    }

    /**
     * Returns an array of class names of prerequisite classes
     *
     * This way a wizard can define dependencies like "database up-to-date" or
     * "reference index updated"
     *
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        // Add your logic here
    }
}
