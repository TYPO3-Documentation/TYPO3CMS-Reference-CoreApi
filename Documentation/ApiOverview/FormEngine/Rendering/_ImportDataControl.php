<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FormEngine\FieldControl;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Information\Typo3Version;

final class ImportDataControl extends AbstractNode
{
    private string $langFile = 'LLL:EXT:my_extension/Ressources/Private/Language/locallang_db.xlf';

    public function __construct(private readonly Typo3Version $typo3Version) {}

    public function render(): array
    {
        $result = [
            'iconIdentifier' => 'import-data',
            'title' => $GLOBALS['LANG']->sL($this->langFile . ':pages.importData'),
            'linkAttributes' => [
                'class' => 'importData ',
                'data-id' => $this->data['databaseRow']['somefield'],
            ],
            'javaScriptModules' => ['@my_vendor/my_extension/import-data.js'],
        ];

        /** @deprecated remove on dropping TYPO3 v11 support */
        if ($this->typo3Version->getMajorVersion() < 12) {
            unset($result['javaScriptModules']);
            $result['requireJsModules'] = ['TYPO3/CMS/Something/ImportData'];
        }

        return $result;
    }
}
