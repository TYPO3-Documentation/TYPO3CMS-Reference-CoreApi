<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\TypoScript;

use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

class CustomTypoScriptConditionProvider extends AbstractProvider
{
    public function __construct()
    {
        $this->expressionLanguageVariables = [
            'variableA' => 'valueB',
        ];
    }
}
