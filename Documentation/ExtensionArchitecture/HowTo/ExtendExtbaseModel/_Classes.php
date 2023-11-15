<?php

declare(strict_types=1);

use MyVendor\MyExtension\Domain\Model\MyExtendedModel;

return [
    MyExtendedModel::class => [
        'tableName' => 'tx_originalextension_somemodel',
    ],
];
