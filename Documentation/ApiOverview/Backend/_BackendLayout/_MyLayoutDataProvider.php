<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataProviders;

use TYPO3\CMS\Backend\View\BackendLayout\BackendLayout;
use TYPO3\CMS\Backend\View\BackendLayout\BackendLayoutCollection;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderContext;
use TYPO3\CMS\Backend\View\BackendLayout\DataProviderInterface;

final class MyLayoutDataProvider implements DataProviderInterface
{
    public function getIdentifier(): string
    {
        return 'my_provider';
    }

    public function addBackendLayouts(
        DataProviderContext $dataProviderContext,
        BackendLayoutCollection $backendLayoutCollection,
    ) {
        // TODO implement
    }

    /**
     * Gets a backend layout by (regular) identifier.
     *
     * @param string $identifier
     * @param int $pageId
     * @return BackendLayout|null
     */
    public function getBackendLayout($identifier, $pageId)
    {
        // TODO implement
    }
}
