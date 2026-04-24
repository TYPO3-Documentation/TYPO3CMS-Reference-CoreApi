<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\FormEngine\FieldControl;

use TYPO3\CMS\Backend\Form\AbstractNode;

final class ImportDataControl extends AbstractNode
{
    private string $languageDomain = 'my_extension:messages';

    public function __construct() {}

    public function render(): array
    {
        $result = [
            'iconIdentifier' => 'import-data',
            'title' => $GLOBALS['LANG']->translate('pages.importData', $this->languageDomain),
            'linkAttributes' => [
                'class' => 'importData ',
                'data-id' => $this->data['databaseRow']['somefield'],
            ],
            'javaScriptModules' => ['@my_vendor/my_extension/import-data.js'],
        ];

        return $result;
    }
}
