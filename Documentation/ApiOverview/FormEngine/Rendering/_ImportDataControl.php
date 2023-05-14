<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FormEngine\FieldControl;

use TYPO3\CMS\Backend\Form\AbstractNode;

final class ImportDataControl extends AbstractNode
{
    private string $langFile = 'LLL:EXT:my_extension/Ressources/Private/Language/locallang_db.xlf';
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
            /** @deprecated remove on dropping TYPO3 v11 support */
            'requireJsModules' => ['TYPO3/CMS/Something/ImportData'],
        ];
        return $result;
    }
}
