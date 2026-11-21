<?php

declare(strict_types=1);

use MyVendor\MyExtension\ExpressionLanguage\CustomTypoScriptConditionProvider;

return [
  'typoscript' => [
    CustomTypoScriptConditionProvider::class,
  ],
];
