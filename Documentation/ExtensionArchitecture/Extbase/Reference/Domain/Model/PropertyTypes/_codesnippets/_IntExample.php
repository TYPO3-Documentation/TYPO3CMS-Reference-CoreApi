<?php
declare(strict_types=1);

namespace Vendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class IntExample extends AbstractEntity
{
    #[Validate([
        'validator' => 'NumberRange',
        'options' => ['minimum' => 0, 'maximum' => 10],
    ])]
    public int $importance = 0;

    #[Validate([
        'validator' => 'NumberRange',
        'options' => ['minimum' => 0, 'maximum' => 3],
    ])]
    public int $status = 0;
}
